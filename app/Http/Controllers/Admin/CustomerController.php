<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function show()  {
        $customer = Customer::get();
        return view('customer.list',['customer'=>$customer]);
    }
    function add() {
        return view('customer.add');
    }
    function insert(Request $request) {
        //code...
    // return $request->all();
        $input = $request->validate([
            'name' =>'required|max:255',
            'fname' =>'required|max:255',
            'mobile_number' =>'required|numeric|digits:11',
            'office_number' =>'nullable|numeric|digits:11',
            'res_number' =>'nullable|numeric|digits:11',
            'nic' =>'required|unique:customers,nic|numeric',
            'email' =>'nullable|email',
            'image' => 'nullable|image',
            'address' => 'nullable|max:255'
        ]);
        try {
        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/customer';
            $filename =rand(10000,999999).$filename;

            $file->move($destinationPath, $filename);
            $input['image'] = $filename;
        }
        // dd($input);
        Customer::create($input);
        return redirect()->route('customer.all-customers')->with('success','Success Customer Inserted');
    } catch (\Exception $ex) {
    return $ex->getMessage();
        return redirect()->back()->with('danger','Some thing went wrong');

    }

    }
    function edit($id)  {
        $customer = Customer::find($id);
        // dd("heelo");
        return view('customer.edit',['customer'=>$customer]);
    }
    function update(Request $request , $id) {
        $customer = Customer::find($id);
        // $input=$request->all();
        $input = $request->validate([
            'name' =>'required|max:255',
            'fname' =>'required|max:255',
            'mobile_number' =>'required|numeric',
            'office_number' =>'nullable|numeric',
            'res_number' =>'nullable|numeric',
            'nic' =>'required|numeric',
            'email' =>'nullable|email',
            'image' => 'nullable|image',
            'address' => 'nullable|max:255'
        ]);
        try {
            //code...

        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/customer';
            $filename =rand(10000,999999).$filename;
            if(file_exists(public_path('images/customer/').$customer->image)){

                unlink('images/customer/'.$customer->image);
            }

            $file->move($destinationPath, $filename);
        }else{
            $filename = $customer->image;
        }
        $input['image'] = $filename;
        $customer->update($input);
        return redirect()->route('customer.all-customers')->with('success','Success Customer Updated');
    } catch (\Exception $ex) {
        return redirect()->back()->with('danger','Some thing went wrong');

    }


    }

    function delete($id){
        $customer = Customer::find($id);


        if( $customer && $customer->applications()->count() > 0){
            return redirect()->back()->with('danger','cant delete this customer,this customer has many data');
        }
        if( $customer->image &&  file_exists(asset('images/customer/').$customer->image)){

            unlink(asset('images/customer').$customer->image);
        }

        $customer->delete();
        return redirect()->back()->with('success','Customer Removed!');
    }
}
