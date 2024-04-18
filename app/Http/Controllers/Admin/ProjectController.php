<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function new()
    {
        return view('project.add');
    }

    public function insert(Request $request)
    {
        $input = $request->validate([
            'project_name' => 'required|unique:projects,project_name',
            'location' => 'required_with:project_name',
            'description'=>'nullable|max:255',
            'amount' => 'required|nullable|max:11',
        ],[
            'project_name.unique' => $request->project_name.' is already exists.',
            'location.required_with' => 'Please set the project location.',
        ]);
        $input['description'] = $request->description;
        Project::create($input);
        return redirect()->route('project.all-projects')->with('success', 'A new project created successfully.');
    }

    public function list()
    {
        $project = Project::orderBy('project_name', 'asc')->get();
        return view('project.list', ['project' => $project])->with('index', 1);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('project.edit', ['data' => $project]);
    }

    public function update(Request $request)
    {


        $id = $request->id;
        $project = Project::find($id);
        $input = $request->validate([
            'project_name' => 'required|unique:projects,project_name,'.$id,
            'location' => 'required_with:project_name',
            'amount' => 'required|numeric',
            'description' => 'nullable|max:255',
        ],[
            'project_name.unique' => $request->project_name.' is already exists.',
            'location.required_with' => 'Please set the project location.',
        ]);
        try {
            //code...

        $project->update($input);
        return redirect()->route('project.all-projects')->with('success', 'Project details updated successfully.');
    } catch (\Exception $ex) {
        return redirect()->back()->with('danger','some thing went wrong');
    }

    }

    public function destroy($id){
        return "not delete yet";
    }
}
