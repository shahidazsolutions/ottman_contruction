<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function show()
    {


        $project = Project::get();
        return view('product.add', ['project' => $project]);
    }
    public function view_project($id)
    {

        $project = Project::get();
        return view('product.list', ['project' => $project])->with('index', 1);
    }
    public function view_products($id)
    {


         $product = Product::where('id', $id)->get();
        return view('product.show', compact('product'));
    }

    // Products
    function all_products()
    {
        $product = Product::all();
        return view('product.list_product', compact('product'));
    }
    public function insert(Request $request)
    {

        // return $request->all();
        $reqFields = $request->validate([
            'project_id' => 'required',
            'room_number' => 'required',
            'floor_number' => 'required',
            'flate_size' => 'required',
            // 'unit_price' => 'required',
            // 'flat_price'=>'required|numeric',
            // 'flat_net_price'=>'nullable|numeric',
            'file' => 'nullable|image'
        ],
        ["file.dimensions"=>'Image less than 900x900.']);
        $Fields = array(
            'booking' => 0,
            // 'parking_charge' => $request->parking_charge,
            // 'utility_charge' => $request->utility_charge,
            // 'additional_charge' => $request->additional_charge,
            // 'other_charge' => $request->other_charge,
            // 'discount_deduction' => $request->discount_deduction,
            // 'refund_charge' => $request->refund_charge,
            // 'description' => $request->description,
            // 'flat_price'=>$request->flat_price

        );
        try {
            //code...
            $filename="";
        if ($request->hasFile('file')) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/file';
            $filename =rand(100000,999999).$filename;
            $file->move($destinationPath, $filename);
        }
        $reqFields['file'] = $filename;
        $find = 1;
        foreach(Product::all() as $products){
            if($request->room_number == $products->room_number && $products->project_id ==$request->project_id  && $request->floor_number == $products->floor_number){
                $find = 0;
                return redirect()->back()->with('danger', 'This flat already added!');
                break;
            }else{
                $find = 1;
            }
        }
        // dd($find);
        if($find == 1){
            // dd(array_merge($reqFields, $Fields));
            Product::create(array_merge($reqFields, $Fields));
        }
        return redirect()->route('products.all-product')->with('success', 'Success Product Inserted');
    } catch (\Exception $ex) {
        return redirect()->back()->with('danger', $ex->getMessage());

    }

    }


    function edit($id)
    {
        $product = Product::find($id);
        $project = Project::get();
        return view('product.edit', ['project' => $project, 'product' => $product]);
    }
    function update(Request $request, $id)
    {

        $product = Product::find($id);
        // $input = $request->all();

        $reqFields = $request->validate([
            'project_id' => 'required',
            'room_number' => 'required',
            'floor_number' => 'required',
            'flate_size' => 'required|numeric',
            'flat_price'=>'required|numeric',
            'unit_price' => 'required|numeric',
            'flat_net_price'=>'nullable|numeric',
            'file' => 'nullable|image',
        ]);
        $Fields = array(
            'parking_charge' => $request->parking_charge,
            'utility_charge' => $request->utility_charge,
            'additional_charge' => $request->additional_charge,
            'other_charge' => $request->other_charge,
            'discount_deduction' => $request->discount_deduction,
            'refund_charge' => $request->refund_charge,
            'description' => $request->description
        );

        if ($request->hasFile('file')) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path() . '/images/file';
            $filename = rand(100000,99999).$filename;

            $file->move($destinationPath, $filename);
        } else {
            $filename = $product->file;
        }
        $reqFields['file'] = $filename;
        $product->update(array_merge($reqFields, $Fields));
        return redirect()->route('products.all-product')->with('success', 'Success Product Updated');
    }

    function delete($id)
    {

        $product = Product::find($id);
        if($product->booking()->count() > 0){
           return redirect()->back()->with('danger','cant delete this , this has many data');
        }


        $product = Product::find($id);

        $product->delete();
        return redirect()->back()->with('danger', 'Product Deleted!');

    }
}
