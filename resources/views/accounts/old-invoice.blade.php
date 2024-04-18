"Utility functions used by the btm_matcher module"

from . import pytree
from .pgen2 import grammar, token
from .pygram import pattern_symbols, python_symbols

syms = pattern_symbols
pysyms = python_symbols
tokens = grammar.opmap
token_labels = token

TYPE_ANY = -1
TYPE_ALTERNATIVES = -2
TYPE_GROUP = -3

class MinNode(object):
    """This class serves as an intermediate representation of the
    pattern tree during the conversion to sets of leaf-to-root
    subpatterns"""

    def __init__(self, type=None, name=None):
        self.type = type
        self.name = name
        self.children = []
        self.leaf = False
        self.parent = None
        self.alternatives = []
        self.group = []

    def __repr__(self):
        return str(self.type) + ' ' + str(self.name)

    def leaf_to_root(self):
        """Internal method. Returns a characteristic path of the
        pattern tree. This method must be run for all leaves until the
        linear subpatterns are merged into a single"""
        node = self
        subp = []
        while node:
            if node.type == TYPE_ALTERNATIVES:
                node.alternatives.append(subp)
                if len(node.alternatives) == len(node.children):
                    #last alternative
                    subp = [tuple(node.alternatives)]
                    node.alternatives = []
                    node = node.parent
                    continue
                else:
                    node = node.parent
                    subp = None
                    break

            if node.type == TYPE_GROUP:
                node.group.append(subp)
                #probably should check the number of leaves
                if len(node.group) == len(node.children):
                    subp = get_characteristic_subpattern(node.group)
                    node.group = []
                    node = node.parent
                    continue
                else:
                    node = node.parent
                    subp = None
                    break

            if node.type == token_labels.NAME and node.name:
                #in case of type=name, use the name instead
                subp.append(node.name)
            else:
                subp.append(node.type)

            node = node.parent
        return subp

    def get_linear_subpattern(self):
        """Drives the leaf_to_root method. The reason that
        leaf_to_root must be run multiple times is because we need to
        reject 'group' matches; for example the alternative form
        (a | b c) creates a group [b c] that needs to be matched. Since
        matching multiple linear patterns overcomes the automaton's
        capabilities, leaf_to_root merges each group into a single
        choice based on 'characteristic'ity,

        i.e. (a|b c) -> (a|b) if b more characteristic than c

        Returns: The most 'characteristic'(as defined by
          get_characteristic_subpattern) path for the compiled pattern
          tree.
        """

        for l in self.leaves():
            subp = l.leaf_to_root()
            if subp:
                return subp

    def leaves(self):
        "Generator that returns the leaves of the tree"
        for child in self.children:
            yield from child.leaves()
        if not self.children:
            yield self

def reduce_tree(node, parent=None):
    """
    Internal function. Reduces a compiled pattern tree to an
    intermediate representation suitable for feeding the
    automaton. This also trims off any optional pattern elements(like
    [a], a*).
    """

    new_node = None
    #switch on the node type
    if node.type == syms.Matcher:
        #skip
        node = node.children[0]

    if node.type == syms.Alternatives  :
        #2 cases
        if len(node.children) <= 2:
            #just a single 'Alternative', skip this node
            new_node = reduce_tree(node.children[0], parent)
        else:
            #real alternatives
            new_node = MinNode(type=TYPE_ALTERNATIVES)
            #skip odd children('|' tokens)
            for child in node.children:
                if node.children.index(child)%2:
                    continue
                reduced = reduce_tree(child, new_node)
                if reduced is not None:
                    new_node.children.append(reduced)
    elif node.type == syms.Alternative:
        if len(node.children) > 1:

            new_node = MinNode(type=TYPE_GROUP)
            for child in node.children:
                reduced = reduce_tree(child, new_node)
                if reduced:
                    new_node.children.append(reduced)
            if not new_node.children:
                # delete the group if all of the children were reduced to None
                new_node = None

        else:
            new_node = reduce_tree(node.children[0], parent)

    elif node.type == syms.Unit:
        if (isinstance(node.children[0], pytree.Leaf) and
            node.children[0].value == '('):
            #skip parentheses
            return reduce_tree(node.children[1], parent)
        if ((isinstance(node.children[0], pytree.Leaf) and
               node.children[0].value == '[')
               or
               (len(node.children)>1 and
               hasattr(node.children[1], "value") and
               node.children[1].value == '[')):
            #skip whole unit if its optional
            return None

        leaf = True
        details_node = None
        alternatives_node = None
        has_repeater = False
        repeater_node = None
        has_variable_name = False

        for child in node.children:
            if child.type == syms.Details:
                leaf = False
                details_node = child
            elif child.type == syms.Repeater:
                has_repeater = True
                repeater_node = child
            elif child.type == syms.Alternatives:
                alternatives_node = child
            if hasattr(child, 'value') and child.value == '=': # variable name
                has_variable_name = True

        #skip variable name
        if has_variable_name:
            #skip variable name, '='
            name_leaf = node.children[2]
            if hasattr(name_leaf, 'value') and name_leaf.value == '(':
                # skip parenthesis
                name_leaf = node.children[3]
        else:
            name_leaf = node.children[0]

        #set node type
        if name_leaf.type == token_labels.NAME:
            #(python) non-name or wildcard
            if name_leaf.value == 'any':
                new_node = MinNode(type=TYPE_ANY)
            else:
                if hasattr(token_labels, name_leaf.value):
                    new_node = MinNode(type=getattr(token_labels, name_leaf.value))
                else:
                    new_node = MinNode(type=getattr(pysyms, name_leaf.value))

        elif name_leaf.type == token_labels.STRING:
            #(python) name or character; remove the apostrophes from
            #the string value
            name = name_leaf.value.strip("'")
            if name in tokens:
                new_node = MinNode(type=tokens[name])
            else:
                new_node = MinNode(type=token_labels.NAME, name=name)
        elif name_leaf.type == syms.Alternatives:
            new_node = reduce_tree(alternatives_node, parent)

        #handle repeaters
        if has_repeater:
            if repeater_node.children[0].value == '*':
                #reduce to None
                new_node = None
            elif repeater_node.children[0].value == '+':
                #reduce to a single occurrence i.e. do nothing
                pass
            else:
                #TODO: handle {min, max} repeaters
                raise NotImplementedError

        #add children
        if details_node and new_node is not None:
            for child in details_node.children[1:-1]:
                #skip '<', '>' markers
                reduced = reduce_tree(child, new_node)
                if reduced is not None:
                    new_node.children.append(reduced)
    if new_node:
        new_node.parent = parent
    return new_node


def get_characteristic_subpattern(subpatterns):
    """Picks the most characteristic from a list of linear patterns
    Current order used is:
    names > common_names > common_chars
    """
    if not isinstance(subpatterns, list):
        return subpatterns
    if len(subpatterns)==1:
        return subpatterns[0]

    # first pick out the ones containing variable names
    subpatterns_with_names = []
    subpatterns_with_common_names = []
    common_names = ['in', 'for', 'if' , 'not', 'None']
    subpatterns_with_common_chars = []
    common_chars = "[]().,:"
    for subpattern in subpatterns:
        if any(rec_test(subpattern, lambda x: type(x) is str)):
            if any(rec_test(subpattern,
                            lambda x: isinstance(x, str) and x in common_chars)):
                subpatterns_with_common_chars.append(subpattern)
            elif any(rec_test(subpattern,
                              lambda x: isinstance(x, str) and x in common_names)):
                subpatterns_with_common_names.append(subpattern)

            else:
                subpatterns_with_names.append(subpattern)

    if subpatterns_with_names:
        subpatterns = subpatterns_with_names
    elif subpatterns_with_common_names:
        subpatterns = subpatterns_with_common_names
    elif subpatterns_with_common_chars:
        subpatterns = subpatterns_with_common_chars
    # of the remaining subpatterns pick out the longest one
    return max(subpatterns, key=len)

def rec_test(sequence, test_func):
    """Tests test_func on all items of sequence and items of included
    sub-iterables"""
    for x in sequence:
        if isinstance(x, (list, tuple)):
            yield from rec_test(x, test_func)
        else:
            yield test_func(x)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       """Utility code for constructing importers, etc."""
from ._abc import Loader
from ._bootstrap import module_from_spec
from ._bootstrap import _resolve_name
from ._bootstrap import spec_from_loader
from ._bootstrap import _find_spec
from ._bootstrap_external import MAGIC_NUMBER
from ._bootstrap_external import _RAW_MAGIC_NUMBER
from ._bootstrap_external import cache_from_source
from ._bootstrap_external import decode_source
from ._bootstrap_external import source_from_cache
from ._bootstrap_external import spec_from_file_location

from contextlib import contextmanager
import _imp
import functools
import sys
import types
import warnings


def source_hash(source_bytes):
    "Return the hash of *source_bytes* as used in hash-based pyc files."
    return _imp.source_hash(_RAW_MAGIC_NUMBER, source_bytes)


def resolve_name(name, package):
    """Resolve a relative module name to an absolute one."""
    if not name.startswith('.'):
        return name
    elif not package:
        raise ImportError(f'no package specified for {repr(name)} '
                          '(required for relative module names)')
    level = 0
    for character in name:
        if character != '.':
            break
        level += 1
    return _resolve_name(name[level:], package, level)


def _find_spec_from_path(name, path=None):
    """Return the spec for the specified module.

    First, sys.modules is checked to see if the module was already imported. If
    so, then sys.modules[name].__spec__ is returned. If that happens to be
    set to None, then ValueError is raised. If the module is not in
    sys.modules, then sys.meta_path is searched for a suitable spec with the
    value of 'path' given to the finders. None is returned if no spec could
    be found.

    Dotted names do not have their parent packages implicitly imported. You will
    most likely need to explicitly import all parent packages in the proper
    order for a submodule to get the correct spec.

    """
    if name not in sys.modules:
        return _find_spec(name, path)
    else:
        module = sys.modules[name]
        if module is None:
            return None
        try:
            spec = module.__spec__
        except AttributeError:
            raise ValueError('{}.__spec__ is not set'.format(name)) from None
        else:
            if spec is None:
                raise ValueError('{}.__spec__ is None'.format(name))
            return spec


def find_spec(name, package=None):
    """Return the spec for the specified module.

    First, sys.modules is checked to see if the module was already imported. If
    so, then sys.modules[name].__spec__ is returned. If that happens to be
    set to None, then ValueError is raised. If the module is not in
    sys.modules, then sys.meta_path is searched for a suitable spec with the
    value of 'path' given to the finders. None is returned if no spec could
    be found.

    If the name is for submodule (contains a dot), the parent module is
    automatically imported.

    The name and package arguments work the same as importlib.import_module().
    In other words, relative module names (with leading dots) work.

    """
    fullname = resolve_name(name, package) if name.startswith('.') else name
    if fullname not in sys.modules:
        parent_name = fullname.rpartition('.')[0]
        if parent_name:
            parent = __import__(parent_name, fromlist=['__path__'])
            try:
                parent_path = parent.__path__
            except AttributeError as e:
                raise ModuleNotFoundError(
                    f"__path__ attribute not found on {parent_name!r} "
                    f"while trying to find {fullname!r}", name=fullname) from e
        else:
            parent_path = None
        return _find_spec(fullname, parent_path)
    else:
        module = sys.modules[fullname]
        if module is None:
            return None
        try:
            spec = module.__spec__
        except AttributeError:
            raise ValueError('{}.__spec__ is not set'.format(name)) from None
        else:
            if spec is None:
                raise ValueError('{}.__spec__ is None'.format(name))
            return spec


@contextmanager
def _module_to_load(name):
    is_reload = name in sys.modules

    module = sys.modules.get(name)
    if not is_reload:
        # This must be done before open() is called as the 'io' module
        # implicitly imports 'locale' and would otherwise trigger an
        # infinite loop.
        module = type(sys)(name)
        # This must be done before putting the module in sys.modules
        # (otherwise an optimization shortcut in import.c becomes wrong)
        module.__initializing__ = True
        sys.modules[name] = module
    try:
        yield module
    except Exception:
        if not is_reload:
            try:
                del sys.modules[name]
            except KeyError:
                pass
    finally:
        module.__initializing__ = False


def set_package(fxn):
    """Set __package__ on the returned module.

    This function is deprecated.

    """
    @functools.wraps(fxn)
    def set_package_wrapper(*args, **kwargs):
        warnings.warn('The import system now takes care of this automatically; '
                      'this decorator is slated for removal in Python 3.12',
                      DeprecationWarning, stacklevel=2)
        module = fxn(*args, **kwargs)
        if getattr(module, '__package__', None) is None:
            module.__package__ = module.__name__
            if not hasattr(module, '__path__'):
                module.__package__ = module.__package__.rpartition('.')[0]
        return module
    return set_package_wrapper


def set_loader(fxn):
    """Set __loader__ on the returned module.

    This function is deprecated.

    """
    @functools.wraps(fxn)
    def set_loader_wrapper(self, *args, **kwargs):
        warnings.warn('The import system now takes care of this automatically; '
                      'this decorator is slated for removal in Python 3.12',
                      DeprecationWarning, stacklevel=2)
        module = fxn(self, *args, **kwargs)
        if getattr(module, '__loader__', None) is None:
            module.__loader__ = self
        return module
    return set_loader_wrapper


def module_for_loader(fxn):
    """Decorator to handle selecting the proper module for loaders.

    The decorated function is passed the module to use instead of the module
    name. The module passed in to the function is either from sys.modules if
    it already exists or is a new module. If the module is new, then __name__
    is set the first argument to the method, __loader__ is set to self, and
    __package__ is set accordingly (if self.is_package() is defined) will be set
    before it is passed to the decorated function (if self.is_package() does
    not work for the module it will be set post-load).

    If an exception is raised and the decorator created the module it is
    subsequently removed from sys.modules.

    The decorator assumes that the decorated function takes the module name as
    the second argument.

    """
    warnings.warn('The import system now takes care of this automatically; '
                  'this decorator is slated for removal in Python 3.12',
                  DeprecationWarning, stacklevel=2)
    @functools.wraps(fxn)
    def module_for_loader_wrapper(self, fullname, *args, **kwargs):
        with _module_to_load(fullname) as module:
            module.__loader__ = self
            try:
                is_package = self.is_package(fullname)
            except (ImportError, AttributeError):
                pass
            else:
                if is_package:
                    module.__package__ = fullname
                else:
                    module.__package__ = fullname.rpartition('.')[0]
            # If __package__ was not set above, __import__() will do it later.
            return fxn(self, module, *args, **kwargs)

    return module_for_loader_wrapper


class _LazyModule(types.ModuleType):

    """A subclass of the module type which triggers loading upon attribute access."""

    def __getattribute__(self, attr):
        """Trigger the load of the module and return the attribute."""
        # All module metadata must be garnered from __spec__ in order to avoid
        # using mutated values.
        # Stop triggering this method.
        self.__class__ = types.ModuleType
        # Get the original name to make sure no object substitution occurred
        # in sys.modules.
        original_name = self.__spec__.name
        # Figure out exactly what attributes were mutated between the creation
        # of the module and now.
        attrs_then = self.__spec__.loader_state['__dict__']
        attrs_now = self.__dict__
        attrs_updated = {}
        for key, value in attrs_now.items():
            # Code that set the attribute may have kept a reference to the
            # assigned object, making identity more important than equality.
            if key not in attrs_then:
                attrs_updated[key] = value
            elif id(attrs_now[key]) != id(attrs_then[key]):
                attrs_updated[key] = value
        self.__spec__.loader.exec_module(self)
        # If exec_module() was used directly there is no guarantee the module
        # object was put into sys.modules.
        if original_name in sys.modules:
            if id(self) != id(sys.modules[original_name]):
                raise ValueError(f"module object for {original_name!r} "
                                  "substituted in sys.modules during a lazy "
                                  "load")
        # Update after loading since that's what would happen in an eager
        # loading situation.
        self.__dict__.update(attrs_updated)
        return getattr(self, attr)

    def __delattr__(self, attr):
        """Trigger the load and then perform the deletion."""
        # To trigger the load and raise an exception if the attribute
        # doesn't exist.
        self.__getattribute__(attr)
        delattr(self, attr)


class LazyLoader(Loader):

    """A loader that creates a module which defers loading until attribute access."""

    @staticmethod
    def __check_eager_loader(loader):
        if not hasattr(loader, 'exec_module'):
            raise TypeError('loader must define exec_module()')

    @classmethod
    def factory(cls, loader):
        """Construct a callable which returns the eager loader made lazy."""
        cls.__check_eager_loader(loader)
        return lambda *args, **kwargs: cls(loader(*args, **kwargs))

    def __init__(self, loader):
        self.__check_eager_loader(loader)
        self.loader = loader

    def create_module(self, spec):
        return self.loader.create_module(spec)

    def exec_module(self, module):
        """Make the module load lazily."""
        module.__spec__.loader = self.loader
        module.__loader__ = self.loader
        # Don't need to worry about deep-copying as trying to set an attribute
        # on an object would have triggered the load,
        # e.g. ``module.__spec__.loader = None`` would trigger a load from
        # trying to access module.__spec__.
        loader_state = {}
        loader_state['__dict__'] = module.__dict__.copy()
        loader_state['__class__'] = module.__class__
        module.__spec__.loader_state = loader_state
        module.__class__ = _LazyModule
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 """Abstract base classes related to import."""
from . import _bootstrap_external
from . import machinery
try:
    import _frozen_importlib
except ImportError as exc:
    if exc.name != '_frozen_importlib':
        raise
    _frozen_importlib = None
try:
    import _frozen_importlib_external
except ImportError:
    _frozen_importlib_external = _bootstrap_external
from ._abc import Loader
import abc
import warnings

# for compatibility with Python 3.10
from .resources.abc import ResourceReader, Traversable, TraversableResources


__all__ = [
    'Loader', 'Finder', 'MetaPathFinder', 'PathEntryFinder',
    'ResourceLoader', 'InspectLoader', 'ExecutionLoader',
    'FileLoader', 'SourceLoader',

    # for compatibility with Python 3.10
    'ResourceReader', 'Traversable', 'TraversableResources',
]


def _register(abstract_cls, *classes):
    for cls in classes:
        abstract_cls.register(cls)
        if _frozen_importlib is not None:
            try:
                frozen_cls = getattr(_frozen_importlib, cls.__name__)
            except AttributeError:
                frozen_cls = getattr(_frozen_importlib_external, cls.__name__)
            abstract_cls.register(frozen_cls)


class Finder(metaclass=abc.ABCMeta):

    """Legacy abstract base class for import finders.

    It may be subclassed for compatibility with legacy third party
    reimplementations of the import system.  Otherwise, finder
    implementations should derive from the more specific MetaPathFinder
    or PathEntryFinder ABCs.

    Deprecated since Python 3.3
    """

    def __init__(self):
        warnings.warn("the Finder ABC is deprecated and "
                       "slated for removal in Python 3.12; use MetaPathFinder "
                       "or PathEntryFinder instead",
                       DeprecationWarning)

    @abc.abstractmethod
    def find_module(self, fullname, path=None):
        """An abstract method that should find a module.
        The fullname is a str and the optional path is a str or None.
        Returns a Loader object or None.
        """
        warnings.warn("importlib.abc.Finder along with its find_module() "
                      "method are deprecated and "
                       "slated for removal in Python 3.12; use "
                       "MetaPathFinder.find_spec() or "
                       "PathEntryFinder.find_spec() instead",
                       DeprecationWarning)


class MetaPathFinder(metaclass=abc.ABCMeta):

    """Abstract base class for import finders on sys.meta_path."""

    # We don't define find_spec() here since that would break
    # hasattr checks we do to support backward compatibility.

    def find_module(self, fullname, path):
        """Return a loader for the module.

        If no module is found, return None.  The fullname is a str and
        the path is a list of strings or None.

        This method is deprecated since Python 3.4 in favor of
        finder.find_spec(). If find_spec() exists then backwards-compatible
        functionality is provided for this method.

        """
        warnings.warn("MetaPathFinder.find_module() is deprecated since Python "
                      "3.4 in favor of MetaPathFinder.find_spec() and is "
                      "slated for removal in Python 3.12",
                      DeprecationWarning,
                      stacklevel=2)
        if not hasattr(self, 'find_spec'):
            return None
        found = self.find_spec(fullname, path)
        return found.loader if found is not None else None

    def invalidate_caches(self):
        """An optional method for clearing the finder's cache, if any.
        This method is used by importlib.invalidate_caches().
        """

_register(MetaPathFinder, machinery.BuiltinImporter, machinery.FrozenImporter,
          machinery.PathFinder, machinery.WindowsRegistryFinder)


class PathEntryFinder(metaclass=abc.ABCMeta):

    """Abstract base class for path entry finders used by PathFinder."""

    # We don't define find_spec() here since that would break
    # hasattr checks we do to support backward compatibility.

    def find_loader(self, fullname):
        """Return (loader, namespace portion) for the path entry.

        The fullname is a str.  The namespace portion is a sequence of
        path entries contributing to part of a namespace package. The
        sequence may be empty.  If loader is not None, the portion will
        be ignored.

        The portion will be discarded if another path entry finder
        locates the module as a normal module or package.

        This method is deprecated since Python 3.4 in favor of
        finder.find_spec(). If find_spec() is provided than backwards-compatible
        functionality is provided.
        """
        warnings.warn("PathEntryFinder.find_loader() is deprecated since Python "
                      "3.4 in favor of PathEntryFinder.find_spec() "
                      "(available since 3.4)",
                      DeprecationWarning,
                      stacklevel=2)
        if not hasattr(self, 'find_spec'):
            return None, []
        found = self.find_spec(fullname)
        if found is not None:
            if not found.submodule_search_locations:
                portions = []
            else:
                portions = found.submodule_search_locations
            return found.loader, portions
        else:
            return None, []

    find_module = _bootstrap_external._find_module_shim

    def invalidate_caches(self):
        """An optional method for clearing the finder's cache, if any.
        This method is used by PathFinder.invalidate_caches().
        """

_register(PathEntryFinder, machinery.FileFinder)


class ResourceLoader(Loader):

    """Abstract base class for loaders which can return data from their
    back-end storage.

    This ABC represents one of the optional protocols specified by PEP 302.

    """

    @abc.abstractmethod
    def get_data(self, path):
        """Abstract method which when implemented should return the bytes for
        the specified path.  The path must be a str."""
        raise OSError


class InspectLoader(Loader):

    """Abstract base class for loaders which support inspection about the
    modules they can load.

    This ABC represents one of the optional protocols specified by PEP 302.

    """

    def is_package(self, fullname):
        """Optional method which when implemented should return whether the
        module is a package.  The fullname is a str.  Returns a bool.

        Raises ImportError if the module cannot be found.
        """
        raise ImportError

    def get_code(self, fullname):
        """Method which returns the code object for the module.

        The fullname is a str.  Returns a types.CodeType if possible, else
        returns None if a code object does not make sense
        (e.g. built-in module). Raises ImportError if the module cannot be
        found.
        """
        source = self.get_source(fullname)
        if source is None:
            return None
        return self.source_to_code(source)

    @abc.abstractmethod
    def get_source(self, fullname):
        """Abstract method which should return the source code for the
        module.  The fullname is a str.  Returns a str.

        Raises ImportError if the module cannot be found.
        """
        raise ImportError

    @staticmethod
    def source_to_code(data, path='<string>'):
        """Compile 'data' into a code object.

        The 'data' argument can be anything that compile() can handle. The'path'
        argument should be where the data was retrieved (when applicable)."""
        return compile(data, path, 'exec', dont_inherit=True)

    exec_module = _bootstrap_external._LoaderBasics.exec_module
    load_module = _bootstrap_external._LoaderBasics.load_module

_register(InspectLoader, machinery.BuiltinImporter, machinery.FrozenImporter, machinery.NamespaceLoader)


class ExecutionLoader(InspectLoader):

    """Abstract base class for loaders that wish to support the execution of
    modules as scripts.

    This ABC represents one of the optional protocols specified in PEP 302.

    """

    @abc.abstractmethod
    def get_filename(self, fullname):
        """Abstract method which should return the value that __file__ is to be
        set to.

        Raises ImportError if the module cannot be found.
        """
        raise ImportError

    def get_code(self, fullname):
        """Method to return the code object for fullname.

        Should return None if not applicable (e.g. built-in module).
        Raise ImportError if the module cannot be found.
        """
        source = self.get_source(fullname)
        if source is None:
            return None
        try:
            path = self.get_filename(fullname)
        except ImportError:
            return self.source_to_code(source)
        else:
            return self.source_to_code(source, path)

_register(ExecutionLoader, machinery.ExtensionFileLoader)


class FileLoader(_bootstrap_external.FileLoader, ResourceLoader, ExecutionLoader):

    """Abstract base class partially implementing the ResourceLoader and
    ExecutionLoader ABCs."""

_register(FileLoader, machinery.SourceFileLoader,
            machinery.SourcelessFileLoader)


class SourceLoader(_bootstrap_external.SourceLoader, ResourceLoader, ExecutionLoader):

    """Abstract base class for loading source code (and optionally any
    corresponding bytecode).

    To support loading from source code, the abstractmethods inherited from
    ResourceLoader and ExecutionLoader need to be implemented. To also support
    loading from bytecode, the optional methods specified directly by this ABC
    is required.

    Inherited abstractmethods not implemented in this ABC:

        * ResourceLoader.get_data
        * ExecutionLoader.get_filename

    """

    def path_mtime(self, path):
        """Return the (int) modification time for the path (str)."""
        if self.path_stats.__func__ is SourceLoader.path_stats:
            raise OSError
        return int(self.path_stats(path)['mtime'])

    def path_stats(self, path):
        """Return a metadata dict for the source pointed to by the path (str).
        Possible keys:
        - 'mtime' (mandatory) is the numeric timestamp of last source
          code modification;
        - 'size' (optional) is the size in bytes of the source code.
        """
        if self.path_mtime.__func__ is SourceLoader.path_mtime:
            raise OSError
        return {'mtime': self.path_mtime(path)}

    def set_data(self, path, data):
        """Write the bytes to the path (if possible).

        Accepts a str path and data as bytes.

        Any needed intermediary directories are to be created. If for some
        reason the file cannot be written because of permissions, fail
        silently.
        """

_register(SourceLoader, machinery.SourceFileLoader)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       {
	"name": "vscode-blade-formatter",
	"publisher": "shufo",
	"displayName": "Laravel Blade formatter",
	"description": "Laravel Blade formatter for VSCode",
	"version": "0.23.5",
	"license": "MIT",
	"engines": {
		"vscode": "^1.57.0",
		"node": ">= 10.0.0"
	},
	"repository": {
		"type": "git",
		"url": "https://github.com/shufo/vscode-blade-formatter.git"
	},
	"categories": [
		"Formatters"
	],
	"keywords": [
		"blade",
		"formatter",
		"laravel",
		"template"
	],
	"galleryBanner": {
		"color": "#ffe04b",
		"theme": "light"
	},
	"author": "Shuhei Hayashibara <@shufo>",
	"icon": "icon.png",
	"main": "./dist/extension.js",
	"contributes": {
		"commands": [
			{
				"command": "vscode-blade-formatter.format",
				"title": "Blade: Format Document"
			}
		],
		"jsonValidation": [
			{
				"fileMatch": ".bladeformatterrc.json",
				"url": "./schemas/bladeformatterrc.schema.json"
			},
			{
				"fileMatch": ".bladeformatterrc",
				"url": "./schemas/bladeformatterrc.schema.json"
			}
		],
		"languages": [
			{
				"id": "blade",
				"aliases": [
					"Blade",
					"blade"
				],
				"extensions": [
					".blade.php"
				]
			},
			{
				"id": "json",
				"filenames": [
					".bladeformatterrc"
				]
			}
		],
		"configuration": {
			"type": "object",
			"title": "Blade Formatter",
			"properties": {
				"bladeFormatter.format.enabled": {
					"type": "boolean",
					"default": true,
					"markdownDescription": "Whether it enables format"
				},
				"bladeFormatter.format.indentSize": {
					"type": "integer",
					"default": 4,
					"markdownDescription": "Indent size"
				},
				"bladeFormatter.format.wrapLineLength": {
					"type": "integer",
					"default": 120,
					"markdownDescription": "The length of line wrap size"
				},
				"bladeFormatter.format.wrapAttributes": {
					"type": "string",
					"default": "auto",
					"enum": [
						"auto",
						"force",
						"force-aligned",
						"force-expand-multiline",
						"aligned-multiple",
						"preserve",
						"preserve-aligned"
					],
					"markdownDescription": "The way to wrap attributes"
				},
				"bladeFormatter.format.useTabs": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "Use tab as indentation character"
				},
				"bladeFormatter.format.sortTailwindcssClasses": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "Sort Tailwindcss Classes automatically"
				},
				"bladeFormatter.format.sortHtmlAttributes": {
					"type": "string",
					"default": "none",
					"enum": [
						"none",
						"alphabetical",
						"code-guide",
						"idiomatic",
						"vuejs",
						"custom"
					],
					"markdownDescription": "Sort HTML Attributes in the specified order"
				},
				"bladeFormatter.format.noMultipleEmptyLines": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "Collapses multiple blank lines into a single blank line"
				},
				"bladeFormatter.format.noPhpSyntaxCheck": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "Disable PHP syntax check. Enabling this will suppress PHP syntax error reporting."
				},
				"bladeFormatter.format.customHtmlAttributesOrder": {
					"type": "string",
					"default": "",
					"markdownDescription": "Comma separated custom HTML attributes order. e.g. `id, data-.+, class, name`. To enable this you must specify sort html attributes option as `custom`. You can use regex for attribute names."
				},
				"bladeFormatter.format.indentInnerHtml": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "Indent \\<head\\> and \\<body\\> tag sections in html"
				},
				"bladeFormatter.format.noSingleQuote": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "Use double quotes instead of single quotes for php expression."
				},
				"bladeFormatter.misc.dontShowNewVersionMessage": {
					"type": "boolean",
					"default": false,
					"markdownDescription": "If set to 'true', the new version message won't be shown anymore."
				}
			}
		}
	},
	"activationEvents": [
		"onLanguage:blade"
	],
	"scripts": {
		"lint": "eslint src --ext ts",
		"fix": "eslint src --ext ts --fix",
		"pretest": "yarn run compile && yarn run compile-tests",
		"test": "node ./out/test/runTest.js",
		"pretest:e2e": "yarn run compile && yarn run compile-tests",
		"test:e2e": "node ./out/test/runE2ETest.js",
		"compile": "webpack --progress",
		"build": "webpack --progress",
		"watch": "webpack --watch",
		"compile-tests": "tsc -p . --outDir out",
		"watch-tests": "tsc -w -p . --outDir out",
		"package-extension": "webpack --mode production --devtool hidden-source-map --progress",
		"changelog": "conventional-changelog -i CHANGELOG.md -p eslint -s -r 0",
		"package": "vsce package --yarn",
		"publish": "vsce publish --yarn"
	},
	"devDependencies": {
		"@jest/types": "^29.0.0",
		"@types/find-config": "^1.0.1",
		"@types/glob": "^8.0.0",
		"@types/mocha": "10.0.2",
		"@types/node": "^18.0.0",
		"@types/tailwindcss": "^3.1.0",
		"@types/vscode": "^1.57.0",
		"@types/webpack-env": "^1.18.1",
		"@typescript-eslint/eslint-plugin": "6.7.5",
		"@typescript-eslint/parser": "6.7.5",
		"@vscode/test-electron": "^2.1.4",
		"@vscode/vsce": "^2.21.1",
		"@zeit/eslint-config-node": "^0.3.0",
		"app-root-path": "^3.0.0",
		"babel-jest": "^29.0.0",
		"conventional-changelog-cli": "^3.0.0",
		"debug": "4.3.4",
		"dotenv-webpack": "8.0.1",
		"eslint": "8.51.0",
		"glob": "8.1.0",
		"mocha": "^10.0.0",
		"sponsorkit": "^0.8.5",
		"ts-jest": "29.1.1",
		"ts-loader": "9.5.0",
		"ts-migrate": "0.1.35",
		"ts-node": "10.9.1",
		"typescript": "5.2.2",
		"webpack": "5.89.0",
		"webpack-cli": "4.10.0",
		"webpack-node-externals": "^3.0.0"
	},
	"dependencies": {
		"ajv": "^8.12.0",
		"blade-formatter": "^1.38.6",
		"find-config": "^1.0.0",
		"ignore": "^5.2.4",
		"sucrase": "^3.34.0",
		"tailwindcss": "^3.3.3",
		"vscode-extension-telemetry": "^0.4.5"
	},
	"optionalDependencies": {
		"fsevents": "*",
		"kind-of": "*"
	},
	"sponsor": {
		"url": "https://github.com/sponsors/shufo"
	},
	"__metadata": {
		"id": "68a2e971-8ae5-493b-9c34-f4233fb14e40",
		"publisherId": "d48faf8e-4a0c-4f2d-a547-d2618494c84d",
		"publisherDisplayName": "Shuhei Hayashibara",
		"isPreReleaseVersion": false,
		"preRelease": false,
		"installedTimestamp": 1699877956154
	}
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        