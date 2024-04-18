<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{

    public function index(){
        $members = Members::all();

        return view('members.index',compact('members'));
    }

    public function create (){
        return view('members.create');
    }

    public function store (Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'phone'=>'required|digits:11',
            'nic'=>'required|digits:13|unique:members',
            'address'=>'required|max:255'
        ]);

        Members::create([
            'name'=>$request->name,
            'number'=>$request->phone,
            'nic'=>$request->nic,
            'address'=>$request->address,
        ]);

        return redirect()->route('admin.members.index')->with('success','Member added successfully..!');


    }

    public function edit($id){
        $members = Members::where('id',$id)->get();
        return view('members.edit',compact('members'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|max:255',
            'phone'=>'required|digits:11',
            'nic'=>'required|digits:13|unique:members,nic,'.$id ,
            'address'=>'required|max:255'
        ]);

        Members::where('id',$id)->update([
            'name'=>$request->name,
            'number'=>$request->phone,
            'nic'=>$request->nic,
            'address'=>$request->address,
        ]);

        return redirect()->route('admin.members.index')->with('success','Member updated successfully..!');


    }




    public function destroy($id){
        if(Members::find($id)->delete()){
            return redirect()->back()->with('success','Member deleted successfully');
        }
        return redirect()->back()->with('danger','Member not found');


    }


}
