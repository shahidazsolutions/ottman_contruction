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
                        <h3>Monthly Report
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
                <div class="card border">

                    <div class="card-body">
                        <form action="{{ route('report.monthly') }}" method="GET">
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
                                <div class="col-md-6">
                                    <label for="">Select Month <span class="text-danger">*</span> </label>
                                    <input type="month" value="{{ (isset($date))?date('Y-m',strtotime($date)):date('Y-m') }}" class="form-control" name="month">
                                    @error('month')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <input type="submit" name="submit" value="submit" class="btn btn-primary float-end">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <table class="table table-bordered table-hovered">
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Purchase Record</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Supplier Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        @if (isset($purchase))
                        <tbody>

                            @foreach ($purchase as $key=> $purchase)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ $purchase->required_date }}</td>
                                <td>{{ $purchase->description }}</td>
                                <td>{{ formatAmount($purchase->amount) }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th >{{ formatAmount($purchase->sum('amount')) }}</th>

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
                                <th colspan="5" class="text-center">Supplier Payment</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Supplier Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        @if (isset($supplier_payment))
                        <tbody>

                            @foreach ($supplier_payment as $key=> $payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $payment->getSupplier->name }}</td>
                                <td>{{ $payment->date }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>{{ formatAmount($payment->amount) }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th >{{ formatAmount($supplier_payment->sum('amount')) }}</th>
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
                                <th colspan="5" class="text-center">Contractor Payment</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Contractor Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        @if (isset($contractor_payment))
                        <tbody>

                            @foreach ($contractor_payment as $key=> $payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $payment->getContractor->name }}</td>
                                <td>{{ $payment->date }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>{{ formatAmount($payment->amount) }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th >{{ formatAmount($contractor_payment->sum('amount')) }}</th>
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
                                <th colspan="5" class="text-center">Customer Payment</th>
                            </tr>
                            <tr>
                                <th>Sr</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        @if (isset($customer_payment))
                        <tbody>

                            @foreach ($customer_payment as $key=> $payment)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $payment->getCustomer->name }}</td>
                                <td>{{ $payment->date }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>{{ formatAmount($payment->amount) }}</td>
                            </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th >{{ formatAmount($customer_payment->sum('amount')) }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>

</script>

@endsection
