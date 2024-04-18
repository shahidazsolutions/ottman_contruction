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
                        <h3>Supplier Report
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
           <div class="col-12">
               <!-- Specific Project Report Section -->
<div id="specific-project-report">
    <div class="container">
        <h2 class="text-center my-4">Supplier Report</h2>
        <div class="row">
            
            @php
                $total=0;
                $paid = 0;
            @endphp

                 <div class="col-md-6">
               
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                            <th colspan="3">Supplier Purchase</th>
                        </tr>
                        <tr>
                            <th>SR#</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase as $key=> $purchase)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $purchase->requistion_date }}</td>
                            <td>{{ $purchase->amount }}</td>
                                        @php
                $total +=$purchase->amount;
                
            @endphp
                        </tr>
                        @endforeach
                        <!-- Add more rows for additional payments -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total Amount</th>
                            <td>{{ $total ?? 0 }}</td>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>

            <div class="col-md-6">
              
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                            <th colspan="3">Supplier Payments</th>
                        </tr>
                        <tr>
                            <th>Sr#</th>
                            <th>Date</th>
                            <th>Amount Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $key=> $payment)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $payment->date }}</td>
                            <td>{{ $payment->amount }}</td>
                                        @php
                $paid +=$payment->amount;
                
            @endphp
                        </tr>
                        @endforeach
                        <!-- Add more rows for additional payments -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total Paid</th>
                            <td>{{ $paid ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th colspan="2">Remaining</th>
                            <td>{{ $total - $paid ?? 0 }}</td>
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
</div>





@endsection
