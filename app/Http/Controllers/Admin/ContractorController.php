<?php

namespace App\Http\Controllers\Admin;

use App\Models\AsignContractor;
use App\Models\Project;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContractorController extends Controller
{


    public function index(){
        $contractor = Contractor::all();
         return view('contractor.list',compact('contractor'));
    }

    function show($id)  {
        $contractor = Contractor::where('id',$id)->get();
        return view('contractor.show',compact('contractor'));

    }
    function add() {
        return view('contractor.add');
    }
    function insert(Request $request) {
        $input = $request->validate([
            'name' =>'required',
            // 'fname' =>'required',
            'phone' =>'required|unique:contractors,phone|numeric',
            'nic' =>'required|unique:contractors,nic|numeric',
            'email' =>'nullable|email',
            'image' =>'nullable|image',
            'address' =>'required|max:255'
        ]);
        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/contractor';
            $rand = rand(100000,999999);
            $filename = $rand.$filename;

            $file->move($destinationPath, $filename);
            $input['image'] =$filename;
        }
        Contractor::create($input);
        return redirect()->route('contractor.all-contractors')->with('success','Success Contractor Inserted');
    }
    function edit($id)  {
        $contractor = Contractor::find($id);
        // dd("heelo");
        return view('contractor.edit',['contractor'=>$contractor]);
    }
    function update(Request $request , $id) {
        $contractor = Contractor::find($id);
        // $input=$request->all();
        $input = $request->validate([
            'name' =>'required',
            // 'fname' =>'required',
            'phone' =>'required|numeric',
            'nic' =>'required|numeric',
            'email' =>'nullable|email',
            'image' =>'nullable|image',
            'address' =>'required|max:255'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/contractor';
            $rand = rand(100000,999999);
            $filename = $rand.$filename;

            $file->move($destinationPath, $filename);
            $input['image'] = $filename;
        }else{
            $filename = $contractor->image;
        }
        $contractor->update($input);
        return redirect()->route('contractor.all-contractors')->with('success','Success Contractor Updated');
    }
    function delete($id)  {

        $contractor = Contractor::find($id);
         if($contractor->payments()->count()>0 || $contractor->contracts()->count() > 0)
        {
            return redirect()->back()->with('danger','Cant delete contractor. this contractor has many data');
        }
        $contractor->delete();
        return redirect()->back()->with('success','Successfully Deleted!');
    }


    function renderManage(){
        $managerContractor = AsignContractor::orderBy('created_at','desc')->get();
        return view('contractor.manager', compact('managerContractor'))->with('index',1);
    }
    function renderContractDetail($id){
        // if(!$req->session()->has('detail')){
        //     $req->session()->put('detail', $req->detail);
        // }
        $contractor_detail = AsignContractor::find($id);
        if(isset($contractor_detail)){
            $project = Project::find($contractor_detail->project);
            $contractor = Contractor::find($contractor_detail->contractor);
            return view('contractor.contractor-detail', compact('project','contractor','contractor_detail'));
        }else{
            return redirect()->back();
        }
        // return response()->json(['success' => $req->detail['id']]);
        // if($req->session()->has('detail')){
        // }
        // $project =
        // return view('contractor.contractor-detail');
        // Session::put('');
        // $project = Project::find($req->detail['project']);
        // $contractor = Contractor::find($req->detail['contractor']);
    }
    public function renderAsignContractor(){
        $projects = Project::all();
        $contractors = Contractor::all();
        return view('contractor.asign-contractor', compact('projects','contractors'));
        // asign-contractor
    }
    public function asignContractor(Request $req){


$validator = Validator::make($req->all(), [
    'project' => [
        'required',
        function ($attribute, $value, $fail) use ($req) {
            // Check if the project is already assigned to the same contractor
            $existingAssignment = DB::table('asign_contractors')
                ->where('project', $req->input('project'))
                ->where('contractor', $req->input('contractor'))
                ->exists();

            if ($existingAssignment) {
                $fail('This project is already assigned to the same contractor.');
            }
        },
    ],
    'contractor' => 'required',
    'amount' => 'required|numeric',
], [
    'project.required' => 'Please select a project.',
    'contractor.required' => 'Please select a contractor.',
    'amount.required' => 'Please set the amount.',
    'amount.numeric' => 'The amount must be a numeric value.',
]);

if ($validator->fails()) {
    return redirect()->back()->withErrors($validator)->withInput();
}

        try {
            //code...


        AsignContractor::create([
            'project' => $req->project,
            'contractor' => $req->contractor,
            'amount' => $req->amount
        ]);
        return redirect()->route('contractor.manage')->with('success','contract assigned to the contractor');
    } catch (\Exception $ex) {
        return redirect()->back()->with('danger',$ex->getMessage())->withInput();
    }


        // $contractor_detail = AsignContractor::find($id);

    }



}
