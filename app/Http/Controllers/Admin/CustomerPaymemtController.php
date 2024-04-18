<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\FormApplication;
use App\Models\Product;
use App\Models\Project;
use App\Models\TransferFlate;
use Illuminate\Http\Request;

class CustomerPaymemtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $payments = CustomerPayment::all();
        return view('payments.customers.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers =Customer::all();
        return view('payments.customers.create',compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $input =  $request->validate([
            'customer_id'=>'required',
            'project_id'=>'required',
            'flat_id'=>'required',
            'date'=>'required',
            'amount'=>'required|numeric'
        ]);
        try {
            CustomerPayment::create([
                'customer_id'=>$request->customer_id,
                'added_by'=>$request->project_id,
                'customer_id'=>$request->customer_id,
                'project_id'=>$request->project_id,
                'amount'=>$request->amount,
                'flat_id'=>$request->flat_id,
                'date'=>date('Y-m-d'),
        ]);
        return redirect()->route('customer.payments.index')->with('success','payment added successfully');
        } catch (\Throwable $th) {
        return redirect()->back()->with('danger','some thing went wrong');

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
        $customers =Customer::all();

        $payment = CustomerPayment::where('id',$id)->get();
        return view('payments.customers.edit',compact('payment','customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    public function getProject ($customerId)
    {

        $array = [];
        // Fetch projects from both bookings and transfer_flates tables for the selected customer
          $project = FormApplication::
         join('products','form_applications.flat_id','=','products.id')
        ->join('projects','projects.id','=','products.project_id')
        ->where('form_applications.customer_id', $customerId)->
        where('form_applications.is_transfer',0)
        ->groupBy('projects.id')
        ->pluck('projects.id');


        $newProject =  TransferFlate::join('products','products.id','transfer_flates.flat_id')
        ->join('projects','products.project_id','projects.id')
        ->whereNotIn('products.id',$project)
        ->where('transfer_flates.new_customer_id',$customerId)
        ->groupBy('projects.id')
        ->pluck('projects.id');

         $mergedArray = [...($project ?? []), ...($newProject ?? [])];
         $project_id = array_unique($mergedArray, SORT_REGULAR);

         $projects=  Project::whereIn('id',$project_id)->get();




        // Return the projects as JSON response
        return response()->json($projects);
    }

    public function getFlat ($customerId,$projectId)
    {

        // Fetch projects from both bookings and transfer_flates tables for the selected customer
        $flatA = FormApplication::
        join('products','form_applications.flat_id','=','products.id')
        ->join('projects','projects.id','=','products.project_id')->
        where('form_applications.customer_id', $customerId)->where('form_applications.is_transfer',0)->pluck('form_applications.flat_id')->toArray();
        $flatB = TransferFlate::where('new_customer_id', $customerId)->pluck('flat_id')->toArray();
        $flat_id = array_unique(array_merge($flatA, $flatB));

        $flats = Product::whereIn('id',$flat_id)->get();

        // Return the projects as JSON response
        return response()->json($flats);
    }

}
