<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FormApplication;
use App\Models\Product;
use App\Models\TransferFlate;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transfers = TransferFlate::all();
        return view('forms.transfer-form.index',compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function form(Request $request)
    {

        $request->validate([
            'customer_a'=>'required',
            'flat'=>'required',
            'customer_b'=>'required'
        ]);

        $flat_id = $request->flat;
        $customer_a = Customer::where('id',$request->customer_a)->get();
       $customer_b =  Customer::where('id',$request->customer_b)->get();
        return view('forms.transfer-form.create',compact('customer_a','customer_b','flat_id'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {

        try {
        $credentials = $request->validate([
            'old_customer_nominee'=>'required|max:255',
            'new_customer_nominee'=>'required',
            'new_customer_payment'=>'required'
        ]);
        $credentials['old_customer_id']=$request->old_customer_id;
        $credentials['new_customer_id']=$request->new_customer_id;
        $credentials['flat_id']=$request->flat_id;
        $credentials['old_customer_payment']=$request->old_customer_payment ?? 0;

            TransferFlate::create($credentials);
            FormApplication::where('flat_id',$request->flat_id)->update([
                'is_transfer'=>1
            ]);
            return redirect()->route('form.transfer.index')->with('success','Flat Transfered');
        } catch (\Exception $ex) {
            // return $ex->getMessage();
            return redirect()->route('form.transfer.customers')->with('error',$ex->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transfers = TransferFlate::where('id',$id)->get();
        if(!$transfers->count()>0){

            return redirect()->route('form.transfer.index')->with('error','data not found');
        }
            $customer_a = Customer::where('id',$transfers[0]->old_customer_id)->get();
            $customer_b =  Customer::where('id',$transfers[0]->new_customer_id)->get();
        return view('forms.transfer-form.edit',compact('transfers','customer_a','customer_b'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $credentials = $request->validate([
            'old_customer_nominee'=>'required|max:255',

            'new_customer_nominee'=>'required',
            'old_customer_nic'=>'required|numeric',
            'new_customer_nic'=>'required|numeric',
        ]);
        $credentials['old_customer_payment']=$request->old_customer_payment ?? 0;

        try {
            FormApplication::where('flat_id',$id)->update([
                'is_transfer'=>1
            ]);
            TransferFlate::where('id',$id)->update($credentials);
            return redirect()->route('form.transfer.index')->with('success','Flat Transfer record update');
        } catch (\Exception $ex) {
            return redirect()->route('form.transfer.customers')->with('error',$ex->getMessage());
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function customers(){
        $customers = Customer::all();
        return view('forms.transfer-form.customer',compact('customers'));
    }


    public function getFlat ($customerId)
{

    // Fetch projects from both bookings and transfer_flates tables for the selected customer
    $flatA = FormApplication::where('customer_id', $customerId)->where('is_transfer',0)->pluck('flat_id')->toArray();
    $flatB = TransferFlate::where('new_customer_id', $customerId)->pluck('flat_id')->toArray();
    $flat_id = array_unique(array_merge($flatA, $flatB));

    $flats = Product::whereIn('id',$flat_id)->get();

    // Return the projects as JSON response
    return response()->json($flats);
}
}
