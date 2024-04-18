<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $payments = Payment::where('type','contractor')->get();
        return view('payments.contractors.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $contractors = Contractor::all();

        return view('payments.contractors.create',compact('contractors'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'contractor_id'=>'required',
            'project_id'=>'required',
            'date'=>'date',
            'amount'=>'required',
            'description'=>'nullable|max:255'
        ]);

        try {
            //code...

        Payment::create([
            'amount'=>$request->amount,
            'added_by'=>Auth::user()->id,
            'transfer_to'=>$request->contractor_id,
            'project_id'=>$request->project_id,
            'date'=>$request->date,
            'description'=>$request->description,
            'type'=>'contractor',
            'status'=>1,
        ]);
        return redirect()->route('contractor.payments.index')->with('success','payment added successfully..!');
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
        $contractor_id = $request->contractor_id;
        $projects = DB::table('projects')
                            ->join('asign_contractors', 'projects.id', '=', 'asign_contractors.project')
                            ->select('projects.project_name', 'projects.id')
                            ->where('asign_contractors.contractor',$contractor_id)
                            ->groupBy('projects.id')
                            ->groupBy('asign_contractors.contractor')
                            ->get();

            return response()->json(['status'=>1,'data'=>$projects]);
    }


    public function invoice ($id){
        $payments = Payment::where('id',$id)->where('type','contractor')->get();
        $type='Contractor Invoice';
        return view('invoice.debit',compact('payments','type'));
    }
}
