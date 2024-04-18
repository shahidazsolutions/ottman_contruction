<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ottoman Construction">
    <meta name="keywords" content="Ottoman Construction">
    <meta name="author" content="Ottoman Construction">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" />
    <title>@yield('title') - Ottoman Construction</title>

    <link rel="stylesheet" href="{{ asset('assets/font-awesome/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/admin.css') }}">
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js">
    </script>
    <link rel="stylesheet" href="{{ asset('assets/datatable/datatable.min.css') }}">

    <style>
        .btn-close {
            background: transparent !important;
        }
    </style>

</head>

<body>
    <div class="page-wrapper">
        <div class="page-main-header row">
            <div id="sidebar-toggle" class="toggle-sidebar col-auto">
                <i data-feather="chevrons-left"></i>
            </div>
            <div class="nav-right col p-0">
                <ul class="header-menu" style="">
                    <li style="visibility:hidden;">
                        <div class="d-md-none mobile-search">
                            <i data-feather="search"></i>
                        </div>
                        <div class="form-group search-form">
                            <input type="text" class="form-control" placeholder="Search here...">
                        </div>
                    </li>
                    <li style="visibility:hidden;">
                        <a href="#!" onclick="javascript:toggleFullScreen()">
                            <i data-feather="maximize"></i>
                        </a>
                    </li>
                    <li class="onhover-dropdown notification-box" style="visibility:hidden;">
                        <a href="javascript:void(0)">
                            <i data-feather="bell"></i>
                            <span class="label label-shadow label-pill notification-badge">3</span>
                        </a>
                        <div class="notification-dropdown onhover-show-div">
                            <div class="dropdown-title">
                                <h6>Notifications</h6>
                                <a href="favourites.html">Show all</a>
                            </div>
                            <ul>
                                <li>
                                    <div class="media">
                                        <div class="icon-notification bg-primary-light">
                                            <i class="fab fa-xbox"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6>Item damaged</h6>
                                            <span>8 hours ago, Tadawis 24</span>
                                            <p class="mb-0">"the table is broken:("</p>
                                            <ul class="user-group">
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('assets/images/about/4.jpg') }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li class="reply">
                                                    <a href="javascript:void(0)">
                                                        Reply
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="icon-notification bg-success-light">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6>Payment received</h6>
                                            <span>2 hours ago, Bracka 15</span>
                                            <ul class="user-group">
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('assets/images/about/1.jpg') }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('assets/images/about/2.jpg') }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('assets/images/about/3.jpg') }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media">
                                        <div class="icon-notification bg-warning-light">
                                            <i class="fas fa-comment-dots"></i>
                                        </div>
                                        <div class="media-body">
                                            <h6>New inquiry</h6>
                                            <span>1 Days ago, Krowada 7</span>
                                            <p class="mb-0">"is the villa still available?"</p>
                                            <ul class="user-group">
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('assets/images/about/2.jpg') }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <img src="{{ asset('assets/images/about/3.jpg') }}"
                                                            class="img-fluid" alt="">
                                                    </a>
                                                </li>
                                                <li class="reply">
                                                    <a href="javascript:void(0)">
                                                        Reply
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <div class="profile-avatar onhover-dropdown">
                            <div>
                                @if (Auth::check() && Auth::user()->profile)

                                <img src="{{ asset('images/admin/'.Auth::user()->profile) }}" class="img-fluid" alt="">
                                @else
                                <img src="{{ asset('images/admin/user.jpeg') }}" class="img-fluid" alt="">
                                @endif
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="{{ route('admin.profile') }}"><span>Account </span><i data-feather="user"></i></a></li>
                                <li><a href="{{ route('logout') }}"><span>Logout</span><i data-feather="log-in"></i></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <meta name="csrf-token" content="{{ csrf_token() }}" />
        </div>
        <div class="page-body-wrapper">

            <!-- page sidebar start -->
            <div class="page-sidebar">
                <div class="logo-wrap">
                    <a href="{{ route('dashboard') }}">
                        <h4>Ottoman Construction</h4>
                    </a>
                    <div class="back-btn d-lg-none d-inline-block">
                        <i data-feather="chevrons-left"></i>
                    </div>
                </div>
                <div class="main-sidebar">
                    <div class="user-profile">
                        <div class="media">
                            <div class="change-pic">
                                @if (Auth::check() && Auth::user()->profile)

                                <img src="{{ asset('images/admin/'.Auth::user()->profile) }}" class="img-fluid" alt="">
                                @else
                                <img src="{{ asset('images/admin/user.jpeg') }}" class="img-fluid" alt="">
                                @endif
                            </div>
                            <div class="media-body">
                                <a href="#">
                                    <h6>{{ Auth::user()->name }}</h6>
                                </a>
                                <span class="font-roboto">{{ Auth::user()->email }}</span>
                            </div>
                        </div>
                    </div>
                    <div id="mainsidebar">
                        <ul class="sidebar-menu custom-scrollbar">
                            <li class="sidebar-item">
                                <a href="{{ route('dashboard') }}" class="sidebar-link only-link">
                                    <i data-feather="airplay"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link active">

                                    <i data-feather="users"></i>

                                    <span>Members</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('admin.members.create') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Members
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.members.index') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Members
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('admin.members-payment.index') }}">
                                            <i data-feather="chevrons-right"></i>
                                             Members Payments
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link active">
                                    <i data-feather="grid"></i>

                                    <span>Projects</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('project.add-projects') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Project
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('project.all-projects') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Projects
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i class="fa-brands fa-product-hunt"></i>
                                    <span>Products</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('products.add-product') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Products
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products.all-product') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Products
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Contractor</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('contractor.add') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Contractor
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('contractor.all-contractors') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Contractor
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('contractor.manage') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Manage Contractors
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Supplier</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('supplier.add') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Supplier
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('supplier.show-all') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Supplier
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Customer</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('customer.add-customer') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Customer
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('customer.all-customers') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Customer
                                        </a>
                                    </li>


                                    {{-- <li>
                                        <a href="add-agent-wizard.html">
                                            <i data-feather="chevrons-right"></i>
                                            Add agent wizard <span class="label label-shadow ms-1">new</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="edit-agent.html">
                                            <i data-feather="chevrons-right"></i>
                                            Edit agent
                                        </a>
                                    </li>
                                    <li>
                                        <a href="all-agents.html">
                                            <i data-feather="chevrons-right"></i>
                                            All agents
                                        </a>
                                    </li>
                                    <li>
                                        <a href="agent-invoice.html">
                                            <i data-feather="chevrons-right"></i>
                                            Invoice
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Purchases </span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('purchase-requistion.add') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Purchase Requisition
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('purchase-requistion.all') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Requisitions
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a href="{{ route('purchase.add') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Approve Requisitions
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i class="fa-solid fa-list-check"></i>
                                    <span>Item </span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('items.add') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Item
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('items.all') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Items
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i class="fa-solid fa-u"></i>
                                    <span>Unit </span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('unit.add') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Unit
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('unit.all') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Unit
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Application Form</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('form.find-customer') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Application Form
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('form.all-app-forms') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Application Form
                                        </a>
                                    </li>

                                </ul>
                            </li>


                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Transfer</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('form.transfer.customers') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Add Transfer Form
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('form.transfer.index') }}">
                                            <i data-feather="chevrons-right"></i>
                                            All Transfer Record
                                        </a>
                                    </li>


                                </ul>
                            </li>
                            <hr>
                            {{-- <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="user-plus"></i>
                                    <span>Accounting</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="#">
                                            <i data-feather="chevrons-right"></i>
                                            Sale
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i data-feather="chevrons-right"></i>
                                            Purchase
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i data-feather="chevrons-right"></i>
                                            Expenses
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i data-feather="chevrons-right"></i>
                                            Liability
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('account.invoice')}}">
                                            <i data-feather="chevrons-right"></i>
                                            Invoice
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i data-feather="chevrons-right"></i>
                                            Income Statement
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="layout"></i>
                                    <span>Types</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i data-feather="chevrons-right"></i>
                                            Apartment
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i data-feather="chevrons-right"></i>
                                            Cottage
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i data-feather="chevrons-right"></i>
                                            Condominium
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i data-feather="chevrons-right"></i>
                                            Family House
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="d-none sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link only-link">
                                    <i data-feather="map-pin"></i>
                                    <span>Map</span>
                                </a>
                            </li>
                            <li class="d-none sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link only-link">
                                    <i data-feather="bar-chart-2"></i>

                                    <span>Reports</span>
                                </a>
                            </li> --}}


                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i data-feather="layout"></i>
                                    <span>Payments</span>
                                </a>
                                <ul class="nav-submenu menu-content">

                                    <li class="">
                                        <a href="{{ route('supplier.payments.index') }}" class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Supplier Payments</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('contractor.payments.index') }}"
                                            class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Contractor Payments</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('customer.payments.index') }}" class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Customer Payments</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link">
                                    <i class="fa-solid fa-print"></i>
                                    <span>Reports</span>

                                </a>
                                <ul class="nav-submenu menu-content">

                                    <li class="">
                                        <a href="{{ route('report.customer.payment') }}" class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Customer Report</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('report.supplier.payment') }}" class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Supplier Report</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('report.contractor.payment') }}"
                                            class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Contractor Report</span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a href="{{ route('report.daily') }}"
                                            class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Daily Report</span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a href="{{ route('report.monthly') }}"
                                            class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>Monthly Report</span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a href="{{ route('report.summary') }}"
                                            class="sidebar-link only-link">
                                            <i data-feather="chevrons-right"></i>
                                            <span>summary Report</span>
                                        </a>
                                    </li>






                                </ul>


                            </li>



                            {{--
                            <li class="sidebar-item">
                                <a href="javascript:void(0)" class="sidebar-link active">
                                    <i data-feather="grid"></i>
                                    <span>Exports</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a href="{{ route('export.project') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Export Projects
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('export.product') }}">
                                            <i data-feather="chevrons-right"></i>
                                            Export Products
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                        </ul>
                    </div>
                </div>
            </div>

            <!-- page sidebar end -->
            @yield('content')
            <!-- footer start -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 footer-copyright">
                            <p class="mb-0">Copyright {{ date('Y') }} © <a href="javascript:void(0)">Ottoman
                                    Construction</a> All rights reserved.</p>
                        </div>
                        <div class="col-md-6">
                            <p class="float-end mb-0">Developed by <a href="http://azsolutionspk.com/">AZ Solutions</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <script>
                $(document).ready(function() {
                    toastr.options = {
                        'closeButton': true,
                        'debug': false,
                        'newestOnTop': false,
                        'progressBar': false,
                        'positionClass': 'toast-top-right',
                        'preventDuplicates': false,
                        'showDuration': '1000',
                        'hideDuration': '1000',
                        'timeOut': '5000',
                        'extendedTimeOut': '1000',
                        'showEasing': 'swing',
                        'hideEasing': 'linear',
                        'showMethod': 'fadeIn',
                        'hideMethod': 'fadeOut',
                    }
                });
                // var success = $("#success").val();
                // var warning = $("#warning").val();
                // var danger = $("#danger").val();
                // if (success !== '' && success !== '') {
                //     toastr.success(success);
                // }
                // if (warning !== '' && warning !== '') {
                //     toastr.warning(warning);
                // }
                // if (danger !== '' && danger !== '') {
                //     toastr.error(danger);
                // }


                @if (session('success'))
    toastr.success("{{ session('success') }}");
    {{ session()->forget('success') }}
@endif

@if (session('danger'))
    toastr.error("{{ session('danger') }}");
    {{ session()->forget('danger') }}
@endif

@if (session('error'))
    toastr.error("{{ session('error') }}");
    {{ session()->forget('error') }}
@endif


            </script>
            <!-- footer end -->
        </div>
    </div>

    <!-- tap to top start -->
    <div class="tap-top">
        <div>
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>
    <!-- tap to top end -->

    <!-- customizer start -->
    <!--<div class="customizer-wrap">-->
    <!--    <div class="customizer-links">-->
    <!--        <i data-feather="settings"></i>-->
    <!--    </div>-->
    <!--    <div class="customizer-contain custom-scrollbar">-->
    <!--        <div class="setting-back">-->
    <!--            <i data-feather="x"></i>-->
    <!--        </div>-->
    <!--        <div class="layouts-settings">-->
    <!--            <div class="customizer-title">-->
    <!--                <h6 class="color-4">Layout type</h6>-->
    <!--            </div>-->
    <!--            <div class="option-setting">-->
    <!--                <span>Light</span>-->
    <!--                <label class="switch">-->
    <!--                    <input type="checkbox" name="chk1" value="option" class="setting-check"><span-->
    <!--                        class="switch-state"></span>-->
    <!--                </label>-->
    <!--                <span>Dark</span>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div class="layouts-settings">-->
    <!--            <div class="customizer-title">-->
    <!--                <h6 class="color-4">Layout Direction</h6>-->
    <!--            </div>-->
    <!--            <div class="option-setting">-->
    <!--                <span>LTR</span>-->
    <!--                <label class="switch">-->
    <!--                    <input type="checkbox" name="chk2" value="option" class="setting-check1"><span-->
    <!--                        class="switch-state"></span>-->
    <!--                </label>-->
    <!--                <span>RTL</span>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div class="layouts-settings">-->
    <!--            <div class="customizer-title">-->
    <!--                <h6 class="color-4">Unlimited Color</h6>-->
    <!--            </div>-->
    <!--            <div class="option-setting unlimited-color-layout">-->
    <!--                <div class="form-group">-->
    <!--                    <label for="ColorPicker6">color 6</label>-->
    <!--                    <input id="ColorPicker6" type="color" value="#f35d43" name="Default">-->
    <!--                </div>-->
    <!--                <div class="form-group">-->
    <!--                    <label for="ColorPicker7">color 7</label>-->
    <!--                    <input id="ColorPicker7" type="color" value="#f34451" name="Default">-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/admin-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/admin-script.js') }}"></script>
    <script src="{{ asset('assets/js/customizer.js') }}"></script>
    <script src="https://kit.fontawesome.com/8db15ea8e5.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/color/custom-colorpicker.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/datatable/datatable.min.js') }}"></script>

    @stack('custom-scripts')

    <script>
        new DataTable('#datatable');
    </script>

</body>

</html>
