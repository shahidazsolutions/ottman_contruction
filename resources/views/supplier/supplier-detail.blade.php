@extends('layouts.app')

@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Supplier Information
                                    <small>Welcome to admin panel</small>
                                </h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->

            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5>Supplier Detail</h5>
                            </div>
                            <div class="card-body admin-form">
                                <div class="row">
                                    <div class="col-sm-4 border-bottom pb-2 mt-2">
                                        <div class="input-group mt-1">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-0 fw-bold p-label p-0 pe-2" id="">Supplier Name :</span>
                                            </div>
                                            <input type="text" class="form-control shadow-none border-0 bg-transparent p-0" name="" disabled value="{{$supplier->name}} {{$supplier->fname}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4 pb-2 mt-2">
                                        <div class="input-group mt-1">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-0 fw-bold p-label p-0 pe-2" id="">Supplier Number :</span>
                                            </div>
                                            <input type="text" class="form-control shadow-none border-0 bg-transparent p-0" name="" disabled value="{{$supplier->phone}}">
                                        </div>
                                    </div>
                                </div>
                                <h4 class="text-center mt-5">Invoice Record</h4>
                                <div class="row mt-2 pt-3 border-top">
                                    <div class="table-responsive">
<pre>
{{-- {{print_r($supplierDetail)}} --}}
{{-- @foreach($supplierDetail as $key=>$val)
@php
$project_name = \App\Models\Project::find($key);
@endphp
{{$project_name->project_name}} --}}
{{-- {{$requistion_item->project_name}} --}}
{{-- @foreach ($val as $items)
{{$items->item_id}} --}}
{{-- $requistion_item = \App\Models\PurchaseRequistionItem::find($keys); --}}
{{-- @endforeach
@endforeach --}}
</pre>



                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="1">#</th>
                                                    <th colspan="5">Project Name</th>
                                                    <th colspan="1" class="text-center">Items</th>
                                                    <th colspan="1" class="text-center">Units</th>
                                                    <th colspan="1" class="text-center">Quantity</th>
                                                    <th colspan="1" class="text-center">Per Rate</th>
                                                    <th colspan="1" class="text-center"></th>
                                                    <th colspan="1" class="text-end">Total Amount</th>
                                                    {{-- <th colspan="1" class="text-end col-3">Pay</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalAmount = 0;
                                                @endphp
                                                @foreach($supplierDetail as $key=>$val)
                                                    @php
                                                    $project_name = \App\Models\Project::find($key);
                                                    @endphp
                                                    @foreach ($val as $items)
                                                        @php
                                                        $item = \App\Models\Item::find($items->item_id);
                                                        $unit = \App\Models\Unit::find($items->unit_id);
                                                        @endphp
                                                        <tr>
                                                            <td colspan="1">{{$index++}}</td>
                                                            <td colspan="5">{{$project_name->project_name}}</td>
                                                            <td colspan="1" class="text-center">{{$item->name}}</td>
                                                            <td colspan="1" class="text-center">{{$unit->name}}</td>
                                                            <td colspan="1" class="text-center">{{$items->quantity}}</td>
                                                            <td colspan="1" class="text-center">{{$items->rate}}</td>
                                                            <td colspan="1" class="text-center"></td>
                                                            <td colspan="1" class="text-end">{{ number_format($items->quantity*$items->rate, 2) }}</td>
                                                        </tr>
                                                        @php $totalAmount += $items->quantity*$items->rate; @endphp
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="11" class="border-0"></td>
                                                    <td colspan="1" class="text-end fw-bold d-flex align-items-center justify-content-between">
                                                        <span class="text">Total Amount</span>
                                                        <span>{{ number_format($totalAmount, 2) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="11" class="border-0"></td>
                                                    <td colspan="1" class="text-end fw-bold d-flex align-items-center justify-content-between text-danger">
                                                        <span class="text">Total Pay</span>
                                                        <span>{{ number_format(0, 2) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="11" class="border-0"></td>
                                                    <td colspan="1" class="text-end fw-bold d-flex align-items-center justify-content-between text-success">
                                                        <span class="text">Remaining</span>
                                                        <span>{{ number_format(0, 2) }}</span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->

            <script>
                $(document).on("submit", "", function(e){

                })
            </script>
        </div>

@endsection
