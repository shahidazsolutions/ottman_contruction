<?php

namespace App\Http\Controllers;

use App\Models\MemberPayment as ModelsMemberPayment;
use App\Models\Members;
use Illuminate\Http\Request;

class MemberPayment extends Controller
{
    public function  index(){
        $members = Members::all();
        return view('members.payments.index',compact('members'));

    }
    public function create(){
        $members = Members::all();
        return view('members.payments.create',compact('members'));

    }

    public function store(Request $request){

        $request->validate([
            'member'=>'required',
            'amount'=>'required|numeric',
            'date'=>'required',
            'description'=>'nullable|max:255',
        ]);
        //code...
        try {

        ModelsMemberPayment::create([
            'member_id'=>$request->member,
            'amount'=>$request->amount,
            'date'=>$request->date,
            'description'=>$request->description
        ]);
        return redirect()->route('admin.members-payment.index')->with('success','payment added successfully');
    } catch (\Exception $ex) {
        return redirect()->route('admin.members-payment.index')->with('danger',$ex->getMessage());

    }

    }

    public function show($id){
        $member = Members::where('id',$id)->first();
        if($member){

            return view('members.payments.show',compact('member'));
        }
        return redirect()->back()->with('danger','Member not found');
    }


}
