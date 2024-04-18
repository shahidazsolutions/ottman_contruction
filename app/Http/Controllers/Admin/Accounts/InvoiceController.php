<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AsignContractor;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\InvoiceModel;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseRequistion;
use App\Models\PurchaseRequistionItem;
use App\Models\RequestionId;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    // Select Type
    public function selectType(Request $req){
        $data = array();
        if($req->value == "contractor"){
            $data['success'] = $req->value;
            $data['contractor'] = Contractor::all();
        }
        if($req->value == "purchase"){
            $data['success'] = $req->value;
            $data['supplier'] = Supplier::all();
        }
        return response()->json($data);
    }
    // Generate U.C
    public function generateUniqueCode($model_path)
    {
        do {
            $rand = random_int(100000, 999999);
        } while ($model_path::where("order_id", "=", $rand)->first());

        return $rand;
    }
    // Contractor Section
    public function selectContractor(Request $req){
        $data = array();
        if($req->type == "contractor"){
            $projectInfo = array();
            foreach(AsignContractor::where('contractor',$req->contractor_id)->get() as $contractorDetail){
                $project = Project::whereId($contractorDetail->project)->first();
                $projectInfo[$project->id]['project_name'] = $project->project_name;
            }
            $data['success'] = $req->type;
            $data['project'] = $projectInfo;
        }
        return response()->json($data);
    }
    public function renderContractorInvoice(Request $req){
        $data  = array();
        $total_amount = 0;
        $paid = 0;
        $remaining = 0;

        if($req->type == 'contractor'){
            foreach (InvoiceModel::where('contractor', $req->contractor_id)->get() as $key => $value) {
                $data['data'][$key] = $value;
                $data['data'][$key]['project_name'] = Project::whereId($value->project)->first()->project_name;
            }
            foreach(AsignContractor::where('contractor',$req->contractor_id)->get() as $contractorDetail){
                $project = Project::whereId($contractorDetail->project)->first();
                $total_amount += AsignContractor::where('contractor',$req->contractor_id)->where('project', $project->id)->first()->amount;
                foreach(InvoiceModel::where('contractor',$req->contractor_id)->where('project', $project->id)->get() as $invoiceModel){
                    $paid += $invoiceModel->paid;
                }
                $inv = InvoiceModel::where('contractor',$req->contractor_id)->where('project', $project->id)->orderBy('id','desc')->limit(1)->first();
                if(isset($inv)){
                    $remaining += $inv->credit;
                }
            }
            $data['calculation']['total_amount'] = $total_amount;
            $data['calculation']['paid'] = $paid;
            $data['calculation']['remaining'] = $remaining;
            $data['success'] = $req->type;
            $data['contractor'] = Contractor::whereId($req->contractor_id)->first();
        }
        return response()->json($data);
    }


    public function payContractor(Request $req){
        // dd();
        // InvoiceModel::where("order_id", "=", $vari)->first()
        // dd($req->project_id);
        // dd($req->all());
        $rules = [
            'project_id' => 'required',
            'amount' => 'required_with:project_id'
        ];
        $messages = [
            'project_id.required' => 'Please select project',
            'amount.required_with' => 'Please set the project amount',
        ];
        $formData = Validator::make($req->all(), $rules, $messages);
        if ($formData->fails()) {
            return response()->json(['error' => $formData->errors() ]);
        }
        $inc = InvoiceModel::where('project',$req->project_id)->where('contractor',$req->contractor_id)->orderBy('id','desc')->limit(1)->first();
        if($inc){
            $asignAmount = $inc->credit;
        }else{
            $asignAmount = AsignContractor::where('project',$req->project_id)->where('contractor',$req->contractor_id)->first()->amount;
        }


        // dd($inc);
        InvoiceModel::create([
            'order_id' => $this->generateUniqueCode('\App\Models\InvoiceModel'),
            'type' => 'contractor',
            'amount' => $asignAmount,
            'paid' => $req->amount,
            'credit' => ($asignAmount - $req->amount),
            'debit' => 0,
            'project' => $req->project_id,
            'contractor' => $req->contractor_id,
            'supplier' => 0
        ]);
        session()->flash('success','Paid to contractor');
        return response()
        ->json(['success' => 'successfully']);
    }
    // Purchase Section
    public function selectSupplier(Request $req){
        // dd($req->all());
        /**
         * SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')) ;
         * SELECT * FROM ottoman_construction.purchase_requistions WHERE `supplier_id` = 4 GROUP BY `supplier_id`;
         */
        $data = array();
        if($req->type == 'purchase'){
            $data['success'] = $req->type;
            // $appprovedRequistions;
            foreach(Purchase::where('supplier_id',$req->supplier_id)->get() as $reqs){
                $data['appprovedRequistions'][$reqs->purchase_reuestion_id] = RequestionId::where('purchase_requestion_id',$reqs->purchase_reuestion_id)->first()->r_id;
            }
        }
        return response()->json($data);
    }
    public function selectProject(Request $req){
        // dd($req->all());
        $data = array();
        if($req->type == "contractor"){
            $data['success'] = $req->type;
            $data['contractor'] = AsignContractor::where('project',$req->project_id)->first();
        }
        return response()->json($data);

        // $data = array();
        // if($req->value == "contractor"){
        //     $data['success'] = $req->value;
        //     $data['project'] = Project::all();
        // }
        // return response()->json($data);
    }
    public function paySupplier(Request $req){
        // dd();
        // InvoiceModel::where("order_id", "=", $vari)->first()
        // dd($req->project_id);
        // dd($req->all());
        $rules = [
            'project_id' => 'required',
            'amount' => 'required_with:project_id'
        ];
        $messages = [
            'project_id.required' => 'Please select project',
            'amount.required_with' => 'Please set the project amount',
        ];
        $formData = Validator::make($req->all(), $rules, $messages);
        if ($formData->fails()) {
            return response()->json(['error' => $formData->errors() ]);
        }
        $asignAmount = AsignContractor::where('project',$req->project_id)->where('contractor',$req->contractor_id)->first()->amount;
        InvoiceModel::create([
            'order_id' => $this->generateUniqueCode('\App\Models\InvoiceModel'),
            'type' => 'contractor',
            'amount' => $asignAmount,
            'paid' => $req->amount,
            'credit' => ($asignAmount - $req->amount),
            'debit' => 0,
            'project' => $req->project_id,
            'contractor' => $req->contractor_id,
            'supplier' => 0
        ]);
        session()->flash('success','Paid to contractor');
        return response()
        ->json(['success' => 'successfully']);
    }
    public function renderSupplierInvoice(Request $req){
        // dd($req->all());
        $data  = array();
        if($req->type == 'purchase'){
            $data['success'] = $req->type;
            $data['purchase_detail'] = "Supplier ki dtail";
            foreach(PurchaseRequistion::where("supplier_id",$req->supplier_id)->get() as $requistions){
                $items = PurchaseRequistionItem::where('purchase_requistion_id', $requistions->id)->first();
                foreach(PurchaseRequistionItem::where('purchase_requistion_id', $requistions->id)->get() as $items){
                    $data['data'][$items->id] = $items;
                    $data['data'][$items->id]['item_id'] = Item::whereId($items->item_id)->first()->name;
                    $data['data'][$items->id]['unit_id'] = Unit::whereId($items->unit_id)->first()->name;
                    $data['data'][$items->id]['project'] = Project::whereId($requistions->project_id)->first()->project_name;
                    // $data['data'][$requistions->supplier_id][$items->id]['item_id'] = $items;

                }
            }
        }
        return response()->json($data);
    }





















    public function renderInvoice(){
        $contractors = DB::table('contractors')
    ->join('asign_contractors', 'contractors.id', '=', 'asign_contractors.contractor')
    ->groupBy('contractors.id')
    ->get();

    $suppliers = DB::table('suppliers')
    ->select('suppliers.name', 'suppliers.id', DB::raw('COUNT(purchases.supplier_id) as purchase_count'))
    ->join('purchases', 'suppliers.id', '=', 'purchases.supplier_id')
    ->groupBy('suppliers.id')
    ->get();



        return view('accounts.invoice',compact('contractors','suppliers'));
    }



    public function invoice(Request $request)   {
        // if type is contractors
        if($request->type=='contrators'){
            $contractor_id = $request->contractor_id;

        }else if($request->type=='suppliers'){
            return $request->type;

        }

    }


    public function  invoice_data(Request $req){
        if ($req->ajax()) {

        $payments = Payment::where('transfer_to',$req->supplier_id)->where('type','supplier');

        }

    }


}




/**
 * public function selectContractor(Request $req){
 *     $data = array();
 *     // dd($req->all());
 *     // dd(AsignContractor::where('contractor',$req->contractor_id)->get());
 *     if($req->type == "contractor"){
 *         $contractorInfo = array();
 *         foreach(AsignContractor::where('contractor',$req->contractor_id)->get() as $contractorDetail){
 *             $project = Project::findOrFail($contractorDetail->project);
 *             $contractor = Contractor::findOrFail($contractorDetail->contractor);
 *             $contractorInfo[$contractorDetail->id]['project_name'] = $project->project_name;
 *             $contractorInfo[$contractorDetail->id]['project_amount'] = $project->amount;
 *             $contractorInfo[$contractorDetail->id]['contractor_name'] = $contractor->name.' '.$contractor->fname;
 *             $contractorInfo[$contractorDetail->id]['contractor_amount'] = $contractorDetail->amount;
 *             $contractorInfo[$contractorDetail->id]['date'] = explode(' ',$contractorDetail->created_at)[0];
 *         }
 *         // $data['contractor'] = ;
 *         $data['success'] = $req->type;
 *         $data['contractor'] = $contractorInfo;
 *     }
 *     return response()->json($data);
 * }
 */
