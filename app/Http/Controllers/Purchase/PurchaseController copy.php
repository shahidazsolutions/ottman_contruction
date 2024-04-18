<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Contractor;
use App\Models\Item;
use App\Models\Project;
use App\Models\Purchase;
use App\Models\PurchaseRequistion;
use App\Models\PurchaseRequistionItem;
use App\Models\RequestionId;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()  {
        $purchase = Purchase::with(['purchase_requistion','employee','supplier'])->get();
        return view('purchase.list',['purchase'=>$purchase,'index'=>1]);
    }
    public function show(Request $request){
        if(isset($request->requistion_id[0])){
            $requestion_id = RequestionId::where('r_id',$request->requistion_id[0])->first();
            // dd($requestion_id);
            $project =  Project::get();
            $supplier =  Supplier::get();
            $unit  = Unit::get();
            $items = Item::get();
            $contractor = Contractor::get();
            $purchase_requistion = PurchaseRequistion::find($requestion_id->purchase_requestion_id);
            $purchase_requistion_item = PurchaseRequistionItem::where('purchase_requistion_id',$requestion_id->purchase_requestion_id)->get();
            $item_count=count($purchase_requistion_item);
            return view('purchase.add',compact('items','unit','project','contractor','purchase_requistion','purchase_requistion_item','item_count','supplier'));
        }else{
            // 623082
            if(!empty($request->requistion_id)){
                $not_id ="requestion";
                $item_count ="0";
                return view('purchase.add',compact('not_id','item_count'));
            }else{
                $reqs = PurchaseRequistion::where('status', 'pending');
                return view('purchase.add', compact('reqs'));
            }
            // $request->validate([
            //     'requistion_id' => 'required',
            // ]);

        }
    }
    public function insert(Request $request)  {

        $input = $request->validate([
            'supplier_id'  	        => 'required',
            'purpose'                 => 'required',
        ]);
        $input['supplier_id'] = $request->supplier_id[0];
        $input['employe_id'] = Auth::user()->id;
        $input['purchase_reuestion_id'] = $request->purchase_reuestion_id;
        // dd($input);
        Purchase::create($input);
        PurchaseRequistion::whereId($request->purchase_reuestion_id)->update(['status'=>'approved']);
        return redirect()->route('purchase-requistion.all')->with('success','Success Purchase Inserted');



    }
    public function remove_purchase($id){
        $purchase = Purchase::find($id);
        $purchase->delete();
        return redirect()->back()->with('success','Successfully Deleted!');
    }


    public function renderPurchase(){
        $projects = array();
        foreach(PurchaseRequistion::where('status','!=','approved')->groupBy('project_id')->get() as $purReqs){
            $projects[$purReqs->id] = Project::whereId($purReqs->project_id)->first();
        }
        // $projects = Project::all();
        return view('purchase.approve-purchase', compact('projects'));
    }

    public function selectProject(Request $req){
        $data = array();
        if(!empty($req->project)){
            $data['success'] = 'suppliers';
            foreach(PurchaseRequistion::where('status','!=','approved')->where('project_id',$req->project)->get() as $purSuppliers){
                $data['supplier'][$purSuppliers->id] = Supplier::whereId($purSuppliers->supplier_id)->first();
            }
        }
        return response()->json($data);
    }

    public function selectSupplier(Request $req){
        $data = array();
        if(!empty($req->project) && !empty($req->supplier)){
            $data['success'] = 'success';
            foreach(PurchaseRequistion::where('status','!=','approved')->where('project_id',$req->project)->where('supplier_id',$req->supplier)->get() as $purSuppliers){
                $data['supplier'][$purSuppliers->id] = RequestionId::where('purchase_requestion_id', $purSuppliers->id)->first();
            }
        }
        return response()->json($data);
    }

}
