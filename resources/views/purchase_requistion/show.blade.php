@extends('layouts.app')

@section('content')
<style>
    .logo {
        width: 250px;
        height: 120px;
    }
</style>
<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Purchase Report
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


        <div class="row bg-white">
           
            @isset($purchase)
            <div class="col-12 text-center">
                <h2>Customer Report</h2>
            </div>
            <div class="col text-center">
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
            </div>
            @foreach ($purchase as $val)

            <div class="col-12 my-3 ps-4">
                <strong>Supplier Name : {{ $val->supplier->name }}</strong>
                    <br>
                <strong>Phone Number : {{ $val->supplier->phone }}</strong>
                    <br>
                <strong>Project : {{ $val->project->project_name }}</strong>
                    <br>
                <strong>Date : {{ $val->required_date }}</strong>
                    
            </div>

            <div class="col-12">





                <table class="table table-hover table-bordered ">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Item</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                             <th>Total</th>
                        </tr>
                    </thead>
                    <tbody> 
                    @php
$total = 0;
                    
                    @endphp
                    @foreach($val->getPurchaseItems as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->item->name }}</td>
                             <td>{{ $item->unit->name }}</td>
                            <td>{{ $item->quantity }}</td>
                             <td>{{ $item->rate }}</td>
                              <td>{{ $item->rate * $item->quantity }}</td>
                                @php
$total += $item->rate * $item->quantity;
                    
                    @endphp
                        </tr>
                    @endforeach
                     

                     
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total</th>
                            <th>{{ $total ?? 0 }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach

            @endisset
        </div>
    </div>
</div>


@endsection
