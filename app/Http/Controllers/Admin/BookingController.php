<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\FormApplication;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // Show All Forms
    public function view_all_forms(){
        // $allCustomers = array();
        // $forms = FormApplication::all();
        // foreach($forms as $form){
        //     foreach(Product::whereId($form->flat_id)->get() as $product){
        //         $allCustomers[Customer::whereId($form->customer_id)->first()->id] [$product->id] = [$form->id];
        //     }
        // }



        // $customers =  DB::table('customers')
        // ->join('form_applications','customers.id','=','form_applications.customer_id')
        // ->select('customers.name','customers.id')
        // ->groupBy('customers.id')
        // ->get();

      $customers = Customer::join('form_applications', 'customers.id', '=', 'form_applications.customer_id')
        ->with('applications')
        ->select('customers.name', 'customers.id')
        ->groupBy('customers.id','customers.name')
        ->orderBy('customers.name') // Change ordering to customer name
        ->get();

            // return $allCustomers;
        return view('forms.all-application-form', compact('customers'));
    }

    public function edit_form(Request $req){
        $form_id = json_decode($req->current_form);
        $rules = [
            'payment_by' => 'required',
            'number' => 'required|numeric',
            'bank_branch' => 'required',
            'flat_preference' => 'required',
            'payment_schedule' => 'required',
            'nominee_name' => 'required',
            'nominee_so_wo' => 'required',
            'nominee_relation' => 'required',
            'nominee_cnic' => 'required|numeric',
        ];
        $messages = [
            'payment_by.required' => 'The payment field is required!'
        ];
        $formData = Validator::make($req->all(), $rules, $messages);
        if ($formData->fails()) {
            session()->flash('danger','Form Not Updated! Please Check');
            return response()->json(['error' => $formData->errors() ]);
        }
        FormApplication::findOrFail($form_id->id)->update([
            'payment_by' => $req->payment_by,
            'number' => $req->number,
            'bank_branch' => $req->bank_branch,
            'flat_preference' => $req->flat_preference,
            'payment_schedule' => $req->payment_schedule,
            'nominee_name' => $req->nominee_name,
            'nominee_so_wo' => $req->nominee_so_wo,
            'nominee_relation' => $req->nominee_relation,
            'nominee_cnic' => $req->nominee_cnic,
        ]);
        session()->flash('success','Form Updated!');
        return response()->json(['success'=> "Form Updated" ]);
    }
    public function remove_form(Request $req){
        $form = FormApplication::findOrFail($req->id);
        Product::whereId($form->flat_id)->update(['booking' => 0]);
        $form->update(['flat_id' => 0]);
        $form->delete();
        return response()->json(['success'=>'Removed!']);
    }
    // End Show All Forms -  Add Application Form
    public $isset_id=0;
    public function find_customer(){
        $all_customers = Customer::all();
        $projects = Project::all();
        return view('forms.application-form',['isset_id'=>$this->isset_id], compact('all_customers', 'projects'));
    }
    public function change_flat_option(Request $req){
        $flats = Product::where('project_id', $req->id)->where('booking', 0)->get();
        if($flats->count() != 0){
            return response()->json(['success' => $flats ]);
        }else{
            return response()->json(['error' => ['message'=>'Flat not registered or is booked by someone!'] ]);
        }
    }
    public function application_form(Request $req){
        $rules = [
            'customer_id' => 'required',
            'project_id' => 'required',
            'flat_id' => 'required_with:project_id'
        ];
        $messages = [
            'customer_id.required' => 'Please select cutomer',
            'project_id.required' => 'Please select project',
            'flat_id.required_with' => 'Please select flat',
        ];
        $formData = Validator::make($req->all(), $rules, $messages, [
            'customer_id' => 'required',
            'project_id' => 'required',
            'flat_id' => 'required_with:project_id'
        ]);
        if ($formData->fails()) {
            return response()->json(['error' => $formData->errors() ]);
        }
        // session()->flash('success','Application Form');
        $this->isset_id = 1;
        return response()
        ->json([
            'success' => 'successfully',
            'isset' => $this->isset_id,
            'customer_id' => $req->customer_id,
            'flat_id' => $req->flat_id,
        ]);
    }

// edit application form
    public function edit_application_form ($id){

        $applications = FormApplication::where('id',$id)->get();
        $all_customers = Customer::all();
        $projects = Project::all();

        return view('forms.edit-application-form',compact('applications','all_customers','projects'));
    }


    //update application

    public function update_application_form(Request $req , $id){


        $req->validate([

            'payment_by' => 'required',
            'number' => 'required|numeric',
            'bank_branch' => 'required',
            'flat_preference' => 'required',
            'payment_schedule' => 'required',
            'nominee_name' => 'required',
            'nominee_so_wo' => 'required',
            'nominee_relation' => 'required',
            'nominee_cnic' => 'required|numeric',
            'installment'=>'required|numeric',
            'flat_price'=>'required|numeric',
            'paid_amount'=>'nullable|numeric'

        ]);
        try {


            //code...

        FormApplication::where('id',$id)->update([
            'payment_by' => $req->payment_by,
            'number' => $req->number,
            'bank_branch' => $req->bank_branch,
            'flat_preference' => $req->flat_preference,
            'payment_schedule' => $req->payment_schedule,
            'nominee_name' => $req->nominee_name,
            'nominee_so_wo' => $req->nominee_so_wo,
            'nominee_relation' => $req->nominee_relation,
            'nominee_cnic' => $req->nominee_cnic,
            'total_amount'=>$req->flat_price,
            'installment'=>$req->installment_amount,
            'paid_amount'=>$req->paid_amount
            ]);
            return redirect()->route('form.all-app-forms')->with('success','form updated succesfully..!');
        } catch (\Exception $ex) {
            return $ex->getMessage();
            return redirect()->back()->with('danger',$ex->getMessage());

        }

    }

    public function view_application_form($isset, $customer, $flat, $edit=null){
        $customer_detail = Customer::whereId($customer)->first();
        $flat_detail = Product::whereId($flat)->first();
        $edit = FormApplication::whereId($edit)->where('customer_id', $customer)->where('flat_id', $flat)->first();
        return view('forms.application-form', ['isset_id' => $isset], compact('customer_detail','flat_detail', 'edit'));

    }
    public function add_application_form(Request $req){

        $req->validate([
            'current_flat_id' => 'required|numeric|unique:form_applications,flat_id',
            'current_customer_id' => 'required|numeric',
            'payment_by' => 'required',
            'number' => 'required|numeric',

            'bank_branch' => 'nullable|max:255',
            'flat_preference' => 'nullable|max:255',
            'payment_schedule' => 'nullable|numeric',
            'nominee_name' => 'required',
            'nominee_so_wo' => 'required',
            'nominee_relation' => 'required',
            'nominee_cnic' => 'required|numeric',
            'paid_amount'=>'nullable|max:11',
            'flat_price'=>'required|numeric',
            'installment'=>'nullable|numeric'

        ]);

        // $rules = [

        // ];
        // $messages = [
        //     'current_flat_id.unique' => 'The flat has already booked by someone!',
        //     'current_flat_id.required' => 'The flat detail cannot be null or empty please Select flat first!',
        //     'current_customer_id.required' => 'The Customer Detail cannot be null or empty please Select flat first!'
        // ];
        // $formData = Validator::make($req->all(), $rules, $messages);

        // if ($formData->fails()) {
        //     return response()->json(['error' => $formData->errors() ]);

        // }

        $date = date('Y-m-y');
        FormApplication::create([
            'payment_by' => $req->payment_by,
            'number' => $req->number,
            'date' => $date,
            'bank_branch' => $req->bank_branch,
            'flat_preference' => $req->flat_preference,
            'payment_schedule' => $req->payment_schedule,
            'nominee_name' => $req->nominee_name,
            'nominee_so_wo' => $req->nominee_so_wo,
            'nominee_relation' => $req->nominee_relation,
            'nominee_cnic' => $req->nominee_cnic,
            'customer_id' => $req->current_customer_id,
            'flat_id' => $req->current_flat_id,
            'total_amount'=>$req->flat_price,
            'installment'=>$req->installment,
            'paid_amount'=>$req->paid_amount ?? 0
        ]);
        Product::whereId($req->current_flat_id)->update(['booking' => 1]);
        return redirect()->route('form.all-app-forms')->with('success','form added successfully');
    }
    // END Add Application Form



    // Print
    public function print_form(Request $req){
        return response()->json(['success'=>$req->all()]);
    }



    public function invoice ($id){
        $applications = FormApplication::where('id',$id)->get();
        return view('forms.invoice',compact('applications'));
    }

}


// 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
