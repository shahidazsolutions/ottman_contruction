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

class PurchaseRequistionController extends Controller
{
    public function index()  {
        $purchase_requistion = PurchaseRequistion::with(['project','employee','requistion_id','supplier'])->orderby('id','desc')->get();
        // dd($purchase_requistion);
        return view('purchase_requistion.list',['purchase_requistion'=>$purchase_requistion,'index'=>1]);
    }
    public function add()  {
        $project =  Project::get();
        $unit  = Unit::get();
        $items = Item::get();
        $supplier = Supplier::get();
        return view('purchase_requistion.add',compact('items','unit','project','supplier'));
    }
    public function generateUniqueCode()
    {
        do {
            $ranNum = random_int(100000, 999999);
        } while (RequestionId::where("r_id", "=", $ranNum)->first());

        return $ranNum;
    }
    public function insert(Request $request) {
        // dd('Ok');
        //code...

        try {
        $input = $request->validate([
            'project_id' => 'required',
            'supplier_id' => 'required',
            'requistion_date' => 'required',
            'required_date' => 'required',
            'remark' => 'nullable|max:255',
            'image' => 'nullable|image',
            'amount' => 'required|numeric',
            'unit_id.*' => 'required',
            'item_id.*' => 'required',
            'quantity.*' => 'required',
            'rate.*' => 'required',
        ]);


        // dd($input);
        // /*

        if (!empty($request->image)) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('images/purchase'), $filename);
            $input['image'] = $filename;
        }
        $employee_id = Auth::user()->id;
        // $input['amount'] = $request->amount;
        $input['employee_id'] = $employee_id;
        $input['status'] = 'pending';
        $id = PurchaseRequistion::create($input)->id;

        for ($i=0; $i < (count($request->item_id)); $i++) {
            // dd($request->item_id[$i]);
            $purchase_item = [
                'purchase_requistion_id' => $id,
                'item_id'  	             => $request->item_id[$i],
                'unit_id'                => $request->unit_id[$i],
                'quantity'  		     => $request->quantity[$i],
                'rate'                   => $request->rate[$i],
            ];
            PurchaseRequistionItem::create($purchase_item);
        }

        $reqID = [
            'r_id' => $this->generateUniqueCode(),
            "purchase_requestion_id" => $id
        ];
        RequestionId::create($reqID);
        return redirect()->route('purchase-requistion.all')->with('success','Success Project Inserted');
    } catch (\Exception $ex) {
        return redirect()->back()->with('danger',$ex->getMessage());
    }
}
    public function edit(Request $request,$id, $purchase="") {

        $project =  Project::get();
        $unit  = Unit::get();
        $items = Item::get();
        $supplier = Supplier::get();
        $purchase_requistion = PurchaseRequistion::find($id);
        $purchase_requistion_item = PurchaseRequistionItem::where('purchase_requistion_id',$id)->get();
        $item_count=count($purchase_requistion_item);
        return view('purchase_requistion.edit',compact('items','unit','project','supplier','purchase_requistion','purchase_requistion_item','item_count','purchase'));
    }
    public function update(Request $request,$id, $purchase=null){
        if($purchase == "2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q"){
            // dd("as");
            // dd($request->row_item_id);

            $input = $request->validate([
                'unit_id'               => 'required',
                'item_id'               => 'required',
                'quantity'              => 'required',
                'rate'                  => 'required',
            ]);
            PurchaseRequistion::find($id)->update(['total_amount' => $request->total_amount]);
            for ($i=0;$i < (count($request->item_id));$i++) {
                $pId = $request->input('p_id'.$i);
                $getReqItemId = PurchaseRequistionItem::find($request->row_item_id[$i]);
                if(isset($getReqItemId)){
                    $inputReqItems['purchase_requistion_id'] = $id;
                    $inputReqItems['item_id'] = $request->item_id[$i];
                    $inputReqItems['unit_id'] = $request->unit_id[$i];
                    $inputReqItems['quantity'] = $request->quantity[$i];
                    $inputReqItems['rate'] = $request->rate[$i];
                    $getReqItemId->update($inputReqItems);
                }else{
                    $inputReqItems['purchase_requistion_id'] = $id;
                    $inputReqItems['item_id'] = $request->item_id[$i];
                    $inputReqItems['unit_id'] = $request->unit_id[$i];
                    $inputReqItems['quantity'] = $request->quantity[$i];
                    $inputReqItems['rate'] = $request->rate[$i];
                    PurchaseRequistionItem::create($inputReqItems);
                }
            }
            return redirect()->back();
        }
        else{

            $purchaseReq = PurchaseRequistion::find($id);
            $input = $request->validate([
                'project_id'  	        => 'required',
                'supplier_id'  		=> 'required',
                'requistion_date'       => 'required',
                'required_date'         => 'required',
                'remark'                => 'nullable|max:255',
                'image'                => 'nullable|image',
                'amount'          => 'required',
            ]);
            // dd($request->item_id);
            // dd($request->item_id);
            if (!empty($request->image)) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('images/purchase'), $filename);
                $input['image'] = $filename;
            }else{
                $filename= $purchaseReq->image;
            }
            // $input['employee_id'] = Auth::user()->id;
            // dd($input);
            $purchaseReq->update($input);

            $inputReqItems = $request->validate([
                'item_id.*'               => 'required',
                'unit_id.*'               => 'required',
                'quantity.*'              => 'required',
                'rate.*'                  => 'required',
            ]);
            for ($i=0;$i < (count($request->item_id));$i++) {
                $pId = $request->input('p_id'.$i);
                $getReqItemId = PurchaseRequistionItem::find($request->row_item_id[$i]);
                if(isset($getReqItemId)){
                    $inputReqItems['purchase_requistion_id'] = $id;
                    $inputReqItems['item_id'] = $request->item_id[$i];
                    $inputReqItems['unit_id'] = $request->unit_id[$i];
                    $inputReqItems['quantity'] = $request->quantity[$i];
                    $inputReqItems['rate'] = $request->rate[$i];
                    $getReqItemId->update($inputReqItems);
                }else{
                    $inputReqItems['purchase_requistion_id'] = $id;
                    $inputReqItems['item_id'] = $request->item_id[$i];
                    $inputReqItems['unit_id'] = $request->unit_id[$i];
                    $inputReqItems['quantity'] = $request->quantity[$i];
                    $inputReqItems['rate'] = $request->rate[$i];
                    PurchaseRequistionItem::create($inputReqItems);
                }
            }
            return redirect()->back()->with('success','Success Purchase Requistion Updated');
        }

    }
    public function delete_item(Request $request) {
        // dd($request->data_id);
        $data = PurchaseRequistionItem::find($request->data_id);
        if($data){
            $data->delete();
            return "deleted items";
        }else{
            return redirect()->back()->with('danger','Not Deleted');
        }
    }
    public function remove_purchase_request($id){
        $purchase = PurchaseRequistion::find($id);
        $purchase->delete();
        return redirect()->back()->with('success','Successfully Deleted!');
    }
    // REQUISTION LIST
    public function add_requistion_list(){
        $requistion_items = PurchaseRequistionItem::orderBy('id','desc')->first();
        $items = Item::get();
        $units  = Unit::get();
        // return view('purchase_requistion.add',compact('items'));
        // $row="";
        // foreach($requistion_items as $req_item){
        //     foreach($items as $item){
        //         $row = $item->name;
        //         // foreach($units as $unit){
        //         //     $row .= $req_item->id;
        //         // }
        //     }
        // }
        // return $row;
        // return [$requistion_items , $unit , $items];
    }


    public function confirm(Request $request ,$id){


        try {
            //code...

        $request->validate([
            'remark'=>'required',
            'supplier_id'=>'required',
            'item_id.*'=>'required',
            'unit_id.*'=>'required',
            'quantity.*'=>'required',
            'rate.*'=>'required',
            'amount'=>'required',
        ]);


        PurchaseRequistion::where('id',$id)->update([
            'supplier_id'=>$request->supplier_id,
            'remark'=>$request->remark,
            'status'=>'confirmed',
            'amount'=>$request->amount,

        ]);

        PurchaseRequistionItem::where('purchase_requistion_id',$id)->delete();
        foreach ($request->item_id as $key => $value) {
            $inputReqItems =new PurchaseRequistionItem();
            $inputReqItems->purchase_requistion_id = $id;
            $inputReqItems->item_id = $request->item_id[$key];
            $inputReqItems->unit_id = $request->unit_id[$key];
            $inputReqItems->quantity = $request->quantity[$key];
            $inputReqItems->rate = $request->rate[$key];
            $inputReqItems->save();
        }
        Purchase::create([
            'employe_id'=>Auth::user()->id,
            'supplier_id'=>$request->supplier_id,
            'purchase_reuestion_id'=>$id,
        ]);
        return redirect()->route('purchase-requistion.all')->with('success','purchase confirmed succesffully');


    } catch (\Exception $ex) {
        return redirect()->back()->with('danger',$ex->getMessage());
    }




    }

    public function show($id){
        $purchase=  PurchaseRequistion::where('id',$id)->get();
         return view('purchase_requistion.show',compact('purchase'));
    }

}
