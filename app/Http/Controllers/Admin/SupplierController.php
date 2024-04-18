<?php

namespace App\Http\Controllers\Admin;

use App\Models\PurchaseRequistion;
use App\Models\PurchaseRequistionItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SupplierController extends Controller
{
    function show()  {
        $supplier = Supplier::get();
        return view('supplier.list',['supplier'=>$supplier]);
    }

     function show_supplier($id)  {

         $supplier = Supplier::where('id',$id)->get();
        return view('supplier.show',compact('supplier'));
    }
    function add() {
        return view('supplier.add');
    }
    function insert(Request $request) {
        $input = $request->validate([
            'name' =>'required|string',
            'phone' =>'required|unique:suppliers,phone|numeric',
            'nic' =>'required|unique:suppliers,nic|numeric',
            'email' =>'nullable|email',
            'image' =>'nullable|image',
            'address' =>'required|max:255'
        ]);
        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/supplier';
            $filename= rand(100000,999999).$filename;
            $file->move($destinationPath, $filename);
            $input['image'] =$filename;
        }
        Supplier::create($input);
        return redirect()->route('supplier.show-all')->with('success','Success Supplier Inserted');
    }
    function edit($id)  {
        $supplier = Supplier::find($id);
        // dd("heelo");
        return view('supplier.edit',['supplier'=>$supplier]);
    }
    function update(Request $request , $id) {
        $supplier = Supplier::find($id);
        // $input=$request->all();
        $input = $request->validate([
            'name' =>'required',
            'phone' =>'required|numeric',
            'nic' =>'required|numeric',
            'email' =>'nullable|email',
            'image' =>'nullable|image',
            'address' =>'required|max:255'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/supplier';
            $filename= rand(100000,999999).$filename;
            $file->move($destinationPath, $filename);
            $input['image'] = $filename;

        }else{
            $filename = $supplier->image;
        }

        $supplier->update($input);
        return redirect()->route('supplier.show-all')->with('success','Success Supplier Updated');
    }
    function delete($id){
        $supplier = Supplier::find($id);
        if( $supplier->getPuchase()->count() > 0){
        return redirect()->back()->with('danger','this supplier contains purchase , cant delete this!');
        }

        // $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->back()->with('success','Successfully Deleted!');

    }

    public function renderSupplierDetail($id){
        $supplier = Supplier::find($id);
        $supplierDetail = array();
        foreach(PurchaseRequistion::where('supplier_id',$id)->get() as $key=>$val){
            foreach(PurchaseRequistionItem::where('purchase_requistion_id',$val->id)->get() as $key2=>$val2){
                // $supplierDetail[$id][$val->id][$val2->id] = $val2->item_id;
                $supplierDetail[$val->project_id][$val2->id] = $val2;
            }
        }

        // $supplierDetail[$id][$val->id][$val2->purchase_requistion_id] = $val2->id;
        // $supplierDetail[$id][$val->id] = $val->id;
        // $supplierDetail = PurchaseRequistion::where('supplier_id',$id)->get();
        return view('supplier.supplier-detail', compact('supplier', 'supplierDetail'))->with('index',1);
    }


}
