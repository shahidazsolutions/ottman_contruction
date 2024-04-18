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
                        <h3>Summary Report
                            <small>Welcome to admin panel</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid end -->


    @php
        $total_expense=0;
    @endphp
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border">

                    <div class="card-body">
                        <form action="{{ route('report.summary') }}" method="GET">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="">Select Project <span class="text-danger">*</span> </label>
                                    <select name="project_id" class="form-control" id="">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                         <option {{ (isset($project_id) && $project_id==$project->id)?"selected":"" }}  value="{{ $project->id }}">{{ $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <input type="submit" name="submit" value="submit" class="btn btn-primary float-end">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <table class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Purchase Record</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Supplier Name</th>
                                <th>Total Purchase</th>
                                <th>Paid Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        @if (isset($purchase))
                        @php
                        $total_purchase  = 0;
                        $total_paid =0;
                        $total_remaining = 0;
                    @endphp
                        <tbody>

                            @foreach ($purchase as $key=> $purchase)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ formatAmount($purchase->supplier->getPuchase()->sum('amount')) }}</td>
                                <td>{{ formatAmount($purchase->supplier->getProjectPayment($purchase->supplier_id,$purchase->project_id)) }}</td>
                                <th>{{ formatAmount( $purchase->supplier->getPuchase()->sum('amount') - $purchase->supplier->getProjectPayment($purchase->supplier_id,$purchase->project_id)) }}</th>
                            </tr>
                            @php
                                $total_purchase += $purchase->supplier->getPuchase()->sum('amount');
                                $total_paid += $purchase->supplier->getProjectPayment($purchase->supplier_id,$purchase->project_id);
                                $total_remaining += $purchase->supplier->getPuchase()->sum('amount') - $purchase->supplier->getProjectPayment($purchase->supplier_id,$purchase->project_id);

                                $total_expense += $purchase->supplier->getProjectPayment($purchase->supplier_id,$purchase->project_id);
                            @endphp

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th>{{ formatAmount($total_purchase)  }}</th>
                                <th>{{ formatAmount($total_paid)  }}</th>
                                <th>{{ formatAmount($total_remaining)  }}</th>


                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>







            <div class="col-md-6">
                <div class="card">
                    <table class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Project Asigned Contractors</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Contract Name</th>
                                <th>Expected Amount</th>
                                <th>Total Payment</th>
                                <th>Balance</th>

                            </tr>
                        </thead>
                        @if (isset($contracts))
                        @php
                        $total_expected =0;
                        $total_paid = 0;
                        $balance = 0;
                    @endphp
                        <tbody>

                            @foreach ($contracts as $key=> $contract)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <th>{{ $contract->getContractor->name }}</th>
                                <th>{{ formatAmount($contract->amount) }}</th>
                                <th>{{ formatAmount($contract->contractPayment($contract->contractor,$contract->project)) }}</th>
                                <th>{{ formatAmount( $contract->amount - $contract->contractPayment($contract->contractor,$contract->project)) }}</th>


                            </tr>
                            @php
                                $total_expected += $contract->amount;
                                $total_paid += $contract->contractPayment($contract->contractor,$contract->project);
                                $balance += $contract->amount - $contract->contractPayment($contract->contractor,$contract->project);


                                $total_expense += $contract->contractPayment($contract->contractor,$contract->project);


                            @endphp

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th >{{ formatAmount($total_expected) }}</th>
                                <th >{{ formatAmount($total_paid) }}</th>
                                <th >{{ formatAmount($balance) }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>



            {{-- <div class="col-md-6">
                <div class="card">
                    <table class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Contractor Payment</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Contractor Name</th>
                                <th>Paid Amount</th>
                                <th>Remaining Balance</th>
                            </tr>
                        </thead>
                        @if (isset($contractor_payment))
                        <tbody>

                            @foreach ($contractor_payment as $key=> $payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $payment->getContractor->name }}</td>
                                <td>{{ formatAmount($payment->amount) }}</td>
                                <td>{{ formatAmount($payment->getContractor->contracts()->sum('amount')) }}</td>

                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th >{{ formatAmount($contractor_payment->sum('amount')) }}</th>

                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div> --}}



            <div class="col-md-6">
                <div class="card">
                    <table class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">Customer Payment</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Customer Name</th>
                                <th>Paid Amount</th>

                            </tr>
                        </thead>
                        @if (isset($customer_payment))
                        <tbody>

                            @foreach ($customer_payment as $key=> $payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $payment->getCustomer->name }}</td>
                                <td>{{ formatAmount($payment->amount) }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th >{{ formatAmount($customer_payment->sum('amount')) }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
        @if (isset($project_detail))

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th colspan="3" class="text-center">Project Detail</th>
                            </tr>
                            <tr>
                                <th>Project budget</th>
                                <th>Total Expense</th>
                                <th>Profit</th>
                            </tr>
                            <tr>
                                <td>{{ formatAmount($project_detail->amount) }}</td>
                                <td>{{ formatAmount($total_expense) }}</td>
                                <th>{{ formatAmount($project_detail->amount - $total_expense) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<script>

</script>

@endsection
