@extends('layouts.app')
@section('title','Contractors')
@section('content')
<div>
    <div class="page-body">
        <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-header-left">
                            <h3>Contractor Details
                                <small>Welcome to admin panel</small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Contractor Details</h5>
                        </div>
                        <div class="card-body admin-form">
                            <div class="row">
                                <div class="col-sm-4 border-bottom pb-2 mt-2">
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text bg-transparent border-0 fw-bold p-label p-0 pe-2"
                                                id="">Project :</span>
                                        </div>
                                        <input type="text" class="form-control shadow-none border-0 bg-transparent p-0"
                                            name="" disabled value="{{$project->project_name}}">
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>

                                <div class="col-sm-4 border-bottom pb-2 mt-2">
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text bg-transparent border-0 fw-bold p-label p-0 pe-2"
                                                id="">Contractor :</span>
                                        </div>
                                        <input type="text" class="form-control shadow-none border-0 bg-transparent p-0"
                                            name="" disabled value="{{$contractor->name}} {{$contractor->fname}}">
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>


                                <div class="col-sm-4 border-bottom pb-2 mt-2">
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text bg-transparent border-0 fw-bold p-label p-0 pe-2"
                                                id="">Amount :</span>
                                        </div>
                                        <input type="text" class="form-control shadow-none border-0 bg-transparent p-0"
                                            name="" disabled value="{{formatAmount($contractor_detail->amount)}} ">
                                    </div>
                                </div>


                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 border-bottom pb-2 mt-2">
                                    <div class="input-group mt-1">
                                        <div class="input-group-prepend">
                                            <span
                                                class="input-group-text bg-transparent border-0 fw-bold p-label p-0 pe-2"
                                                id="">Date :</span>
                                        </div>
                                        <input type="text" class="form-control shadow-none border-0 bg-transparent p-0"
                                            name="" disabled value="{{ date('d-M-Y')}} ">
                                    </div>
                                </div>
                            </div>
                            {{-- purchase
                            expense
                            invoice
                            income satement --}}

                            <h4 class="text-center mt-5">Contractor Payment Record</h4>
                            <div class="row mt-2 pt-3 border-top">
                                <div class="table-responsive">
                                    <table class="table table-border table-hovered border text-center">
                                        <thead>
                                            <tr>

                                                <th colspan="" class="text-center">Order ID</th>
                                                <th colspan="" class="text-center">Payment Date</th>
                                                <th colspan="" class="text-center">Amount</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contractor->getContractPayment($contractor_detail->project,$contractor->id) as $key=> $payment)

                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ date('d-M-y',strtotime($payment->date)) }}</td>
                                                <th>{{ formatAmount($payment->amount) }}</th>
                                            </tr>

                                            @endforeach
                                        </tbody>
                                        <tfoot >
                                            <tr>
                                                <td colspan="2" class=" text-end fw-bolder">Total Amount</td>
                                                <th class=" text-danger fw-bolder">

                                                    <span>{{ number_format($contractor_detail->amount, 2) }}</span>

                                                </th>

                                            </tr>
                                            <tr>

                                                <td colspan="2" class=" text-end fw-bolder">Paid Amount</td>
                                                <th class=" text-success fw-bolder">

                                                    <span>{{ number_format($contractor->getContractPayment($contractor_detail->project,$contractor->id)->sum('amount'), 2) }}</span>

                                                </th>

                                            </tr>

                                            <tr>
                                                <td colspan="2" class=" text-end fw-bolder">Remainings</td>
                                                <th class=" text-danger fw-bolder">

                                                    <span>{{ number_format($contractor_detail->amount-$contractor->getContractPayment($contractor_detail->project,$contractor->id)->sum('amount'), 2) }}</span>

                                                </th>


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
    </div>
</div>

@endsection
