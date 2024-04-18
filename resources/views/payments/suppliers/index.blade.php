@extends('layouts.app')

@section('content')

<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Supplier Payments
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
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h5>All Payments</h5>
                        <a href="{{ route('supplier.payments.create') }}" class="btn btn-primary float-end">Add
                            Payment</a>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered table-hover" id="datatable">
                            <thead>

                                <tr>
                                    <th>Sr</th>
                                    <th>Supplier Name</th>
                                    <th>Project</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Paid By</th>
                                    <th>More</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $key=> $payment)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $payment->getSupplier->name }}</td>

                                    <td>{{ $payment->project->project_name }}</td>
                                    <td>{{ formatAmount($payment->amount) }}</td>
                                    <td>{{ $payment->date }}</td>
                                    <td>{{ $payment->getAuth->name }}</td>
                                    <td style="text-align: center;">

                                        <a  href="{{ route('supplier.payments.invoice',$payment->id) }}" class="btn btn-dashed-second btn-pill color-1">
                                            <i class="fa-solid fa-print"></i>
                                        </a>

                                        <!--<a  data-bs-toggle="modal" data-bs-target="#delete{{ $payment->id }}" class="btn btn-dashed-second btn-pill color-4"><i class="fa-solid fa-trash"-->
                                        <!--        aria-hidden="true"></i></a>-->
                                    </td>
                                </tr>



                                <!-- Modal -->
                                <div class="modal fade" id="delete{{ $payment->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <form action="{{ route('supplier.payments.destroy',$payment->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Payment Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">X</button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>Do you want to delete this payment?</strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Yes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>

                        </table>

                    </div>


                </div>
            </div>

        </div>
    </div>
</div>




@endsection
