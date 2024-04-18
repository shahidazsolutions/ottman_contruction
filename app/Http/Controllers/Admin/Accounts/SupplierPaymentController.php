<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $payments = Payment::where('type','supplier')->get();
        return view('payments.suppliers.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $suppliers = DB::table('suppliers')
        ->select('suppliers.name', 'suppliers.id', DB::raw('COUNT(purchases.supplier_id) as purchase_count'))
        ->join('purchases', 'suppliers.id', '=', 'purchases.supplier_id')
        ->groupBy('suppliers.id')
        ->get();

        return view('payments.suppliers.create',compact('suppliers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'supplier_id'=>'required',
            'project_id'=>'required',
            'date'=>'date',
            'description'=>'nullable|max:255',
            'amount'=>'required'
        ]);

        try {
            //code...

        Payment::create([
            'amount'=>$request->amount,
            'added_by'=>Auth::user()->id,
            'transfer_to'=>$request->supplier_id,
            'project_id'=>$request->project_id,
            'date'=>$request->date,
            'description'=>$request->description,
            'type'=>'supplier',
            'status'=>1,
        ]);
        return redirect()->route('supplier.payments.index')->with('success','payment added successfully..!');
    } catch (\Exception $ex) {
        return $ex->getMessage();
        return redirect()->back()->with('danger','Some thing went wrong');

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
        //
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
        //
    }


    public function  get_project(Request $request){
        $supplier_id = $request->supplier_id;
        $projects = DB::table('projects')
                            ->join('purchase_requistions', 'projects.id', '=', 'purchase_requistions.project_id')
                            ->select('projects.project_name', 'projects.id')
                            ->where('purchase_requistions.status','confirmed')
                            ->where('purchase_requistions.supplier_id',$supplier_id)
                            ->groupBy('projects.id')
                            ->groupBy('purchase_requistions.supplier_id')
                            ->get();

            return response()->json(['status'=>1,'data'=>$projects]);
    }

   public function invoice ($id){
        $payments = Payment::where('id',$id)->where('type','supplier')->get();
        $type='Supplier Invoice';
        return view('invoice.debit',compact('payments','type'));
    }

}
