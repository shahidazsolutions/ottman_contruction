<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Payment;
use App\Models\AsignContractor;
use App\Models\PurchaseRequistion;
use App\Models\Contractor;
use App\Models\CustomerPayment;
use App\Models\FormApplication;
use App\Models\Product;
use App\Models\Project;
use App\Models\TransferFlate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    // customer report

    public function customer_payment(){
        $customers = Customer::all();

        return view('reports.customer.payment',compact('customers'));
    }

    public function customer_payment_print (Request $request){
        $transfer = 0;
        $customers = Customer::all();

        $validator = Validator::make($request->all(),[
            'customer_id'=>'required',
            'project_id'=>'required',
            'flat_id'=>'required',
        ],[
            'customer_id.required'=>'customer field is required',
            'flat_id.required'=>'flat field is required',

            'project_id.required'=>'project field is required',

        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

         $record = FormApplication::where('customer_id',$request->customer_id)
        ->where('flat_id',$request->flat_id)
        ->get();

        if(!$record->count()>0){
            $record = TransferFlate::where('new_customer_id',$request->customer_id)->where('flat_id',$request->flat_id)
            ->get();
            $transfer = 1;
        }

        $customer_detail = Customer::where('id',$request->customer_id)->first();

        return view('reports.customer.print',compact('transfer','record','customers','customer_detail'));

    }



    public function getProject ($customerId)
    {

        $array = [];
        // Fetch projects from both bookings and transfer_flates tables for the selected customer
          $project = FormApplication::
         join('products','form_applications.flat_id','=','products.id')
        ->join('projects','projects.id','=','products.project_id')
        ->where('form_applications.customer_id', $customerId)->
        groupBy('projects.id')
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
        where('form_applications.customer_id', $customerId)->pluck('form_applications.flat_id')->toArray();
        $flatB = TransferFlate::where('new_customer_id', $customerId)->pluck('flat_id')->toArray();
        $flat_id = array_unique(array_merge($flatA, $flatB));

        $flats = Product::whereIn('id',$flat_id)->get();

        // Return the projects as JSON response
        return response()->json($flats);
    }




    // contractor report
    public function contractor_payment(){
        $contractors = Contractor::all();

        return view('reports.contractor.payment',compact('contractors'));
    }

    public function contractor_payment_print (Request $request){
        $transfer = 0;
        $contractors = Contractor::all();
            $contractor_detail = Contractor::find($request->contractor_id);

        $validator = Validator::make($request->all(),[
            'contractor_id'=>'required',
            'project_id'=>'required',
        ],[
            'contractor_id.required'=>'contractor field is required',

            'project_id.required'=>'project field is required',

        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $payments = Payment::where('transfer_to',$request->contractor_id)->where('project_id',$request->project_id)->where('type','contractor')->get();

        $contract = AsignContractor::select('asign_contractors.*')->join('projects','projects.id','asign_contractors.project')->where('asign_contractors.project',$request->project_id)->where('asign_contractors.contractor',$request->contractor_id)->get();



        return view('reports.contractor.print',compact('contractors','contractor_detail','payments','contract'));

    }



    public function getContractorProject ($contractorId)
    {

        $projects = AsignContractor::join('projects','asign_contractors.project','projects.id')->
        where('asign_contractors.contractor',$contractorId)->select('projects.project_name','projects.id')
        ->get();




        // Return the projects as JSON response
        return response()->json($projects);
    }

    // supplier


    public function supplier_payment(){
        $suppliers = Supplier::all();

        return view('reports.supplier.payment',compact('suppliers'));
    }

    public function supplier_payment_print (Request $request){
        $transfer = 0;
        $suppliers = Supplier::all();
            $supplier_detail = Supplier::find($request->supplier_id);

        $validator = Validator::make($request->all(),[
            'supplier_id'=>'required',
            'project_id'=>'required',
        ],[
            'supplier_id.required'=>'supplier field is required',

            'project_id.required'=>'project field is required',

        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $payments = Payment::where('transfer_to',$request->supplier_id)->where('project_id',$request->project_id)->where('type','supplier')->get();

        $purchase = PurchaseRequistion::where('project_id',$request->project_id)->where('supplier_id',$request->supplier_id)->get();



        return view('reports.supplier.print',compact('payments','purchase'));

    }



    public function getSupplierProject ($supplierId)
    {

    // $projects =     PurchaseRequistion::select('projects.project_name','projects.id')->join('projects','projects.id','purchase_requistions.project_id')
    //     ->where('purchase_requistions.supplier_id',$supplierId)->get();

        $projects = PurchaseRequistion::select('projects.id','projects.project_name')->
        join('projects','projects.id','purchase_requistions.project_id')
        ->where('purchase_requistions.supplier_id',$supplierId)->groupBy('projects.id')->get();

    //     // Return the projects as JSON response
        return response()->json($projects);
     }



     public function monthly_report(Request $request){
       $projects = Project::all();

        if($request->has('project_id') && $request->has('month')){
            $month = $request->month;
            $date = Carbon::parse($month);

            $year = $date->year;
             $month = $date->month;


            $project_id = $request->project_id;

            $purchase = PurchaseRequistion::where('project_id',$project_id)->where('status','confirmed')->whereMonth('required_date',$month)->whereYear('required_date',$year)->get();


            $contractor_payment = Payment::where('project_id',$project_id)->where('type','contractor')->whereMonth('date',$month)->whereYear('date',$year)->get();
            $supplier_payment = Payment::where('project_id',$project_id)->where('type','supplier')->whereMonth('date',$month)->whereYear('date',$year)->get();




            $customer_payment = CustomerPayment::where('project_id',$project_id)->whereMonth('date',$month)->whereYear('date',$year)->get();





        return view('reports.monthly',compact('customer_payment','date','project_id','projects','contractor_payment','supplier_payment','project_id','purchase'));

        }


        return view('reports.monthly',compact('projects'));

     }



     public function daily_report(Request $request){
        $projects = Project::all();

         if($request->has('project_id') && $request->has('date')){
             $date = $request->date;



             $project_id = $request->project_id;

             $purchase = PurchaseRequistion::where('project_id',$project_id)->where('status','confirmed')->where('required_date',$date)->get();


             $contractor_payment = Payment::where('project_id',$project_id)->where('type','contractor')->where('date',$date)->get();
             $supplier_payment = Payment::where('project_id',$project_id)->where('type','supplier')->where('date',$date)->get();




             $customer_payment = CustomerPayment::where('project_id',$project_id)->where('date',$date)->get();





         return view('reports.daily',compact('customer_payment','date','project_id','projects','contractor_payment','supplier_payment','project_id','purchase'));

         }


         return view('reports.daily',compact('projects'));

      }


      public function summary_report(Request $request){
        $projects = Project::all();

         if($request->has('project_id') ){




             $project_id = $request->project_id;

             $purchase = PurchaseRequistion::select('supplier_id','project_id', DB::raw('SUM(amount) as amount'))
             ->where('project_id', $project_id)
             ->where('status', 'confirmed')
             ->groupBy('supplier_id','project_id')
             ->get();



             $contracts = AsignContractor::where('project',$project_id)->get();



             $contractor_payment = Payment::select('transfer_to', DB::raw('SUM(amount) as amount'))->where('project_id',$project_id)->where('type','contractor')->groupBy('transfer_to')->get();

             $supplier_payment = Payment::select('transfer_to', DB::raw('SUM(amount) as amount'))->where('project_id',$project_id)->where('type','supplier')->groupBy('transfer_to')->get();




             $customer_payment = CustomerPayment::select('customer_id', DB::raw('SUM(amount) as amount'))->where('project_id',$project_id)->groupBy('customer_id')->get();


            $project_detail = Project::where('id',$project_id)->first();



         return view('reports.summary',compact('project_detail','customer_payment','contracts','project_id','projects','contractor_payment','supplier_payment','project_id','purchase'));

         }


         return view('reports.summary',compact('projects'));

      }


}
