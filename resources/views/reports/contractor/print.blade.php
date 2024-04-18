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
                        <h3>Contractor Report
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
        <h2 class="text-center my-4">Contractor Report</h2>
        <div class="row g-2">
            
            @php
                $total=0;
                $paid = 0;
            @endphp
    
            @foreach($contract as $contract)
            <div class="col-md-6  p-2">
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                                <th colspan="3">Project Details</th>
                            </tr>
                        <tr>
                            
                            <th>Project Name</th>
                            <td>{{ $contract->getProject->project_name }}</td>
                           
                        </tr>
                        <tr>
                            
                            <th>Project Location</th>
                            <td>{{ $contract->getProject->location }}</td>
                           
                        </tr>
                        
                         <tr>
                            
                            <th>Start Date</th>
                            <td>{{ date('M-d-Y' , strtotime($contract->created_at)) }}</td>
                           
                        </tr>
                        <tr>
                            
                            <th>Excepted Amount</th>
                            <td>{{ $contract->amount }}</td>
                           
                        </tr>
                        
                        
                    </thead>
                </table>
                
             
                            @php
                $total=$contract->amount;
                
            @endphp
            </div>
            @endforeach
            <div class="col-md-6  p-2">
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <tr>
                                <th colspan="3">Contractor Payments</th>
                            </tr>
                        <tr>
                            
                            <th>Date</th>
                            <th>Amount Paid</th>
                            <th>Remaining Amount</th>
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
