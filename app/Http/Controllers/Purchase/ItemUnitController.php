<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Item;
use App\Models\PurchaseRequistionItem;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ItemUnitController extends Controller
{
    // Item Functions
    function showItem()  {
        $item = Item::get();
        return view('item.list',['item'=>$item])->with('index',1);
    }
    function addItem  () {
        return view('item.add');
    }
    function insertItem(Request $request) {
        $input = $request->validate([
            'name' =>'required',
        ]);
        Item::create($input);
        return redirect()->back()->with('success','Success Item Inserted');
       
    }
    function editItem($id)  {
        $item = Item::find($id);
        // dd("heelo");
        return view('item.edit',['item'=>$item]);
    }
    function updateItem(Request $request , $id) {
        $item = Item::find($id);
        $input = $request->validate([
            'name' =>'required',
        ]);
        $item->update($input);
        return redirect()->back()->with('success','Success Item Updated');
    }
    // Unit Functions
    function showUnit()  {
        $unit = Unit::get();
        return view('unit.list',['unit'=>$unit])->with('index',1);
    }
    function addUnit() {
        return view('unit.add');
    }
    function insertUnit(Request $request) {
        $input = $request->validate([
            'name' =>'required'
        ]);
        Unit::create($input);
        return redirect()->back()->with('success','Success Unit Inserted');
    }
    function editUnit($id)  {
        $unit = Unit::find($id);
        // dd("heelo");
        return view('unit.edit',['unit'=>$unit]);
    }
    function updateUnit(Request $request , $id) {
        $unit = Unit::find($id);
        $input = $request->validate([
            'name' =>'required'
        ]);
        $unit->update($input);
        return redirect()->back()->with('success','Success Unit Updated');
    }

    public function remove_item($id){
        Item::find($id)->delete();
        return redirect()->back()->with('success','Success Item Deleted');
    } 
    public function remove_unit($id){
        Unit::find($id)->delete();
        return redirect()->back()->with('success','Success Item Deleted');
    } 
    
}
