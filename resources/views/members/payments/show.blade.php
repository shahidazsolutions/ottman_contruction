@extends('layouts.app')
@section('title','Members')
@section('content')

<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Members
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


                    <div class="card-body admin-form">
                        <ul class="list-group my-3 fw-bold w-50">
                            <li class="list-group-item ">Member Name : {{ $member->name }}</li>
                            <li class="list-group-item">Member Phone : {{ $member->number }}</li>
                            <li class="list-group-item">Member CNIC : {{ $member->nic }}</li>
                        </ul>

                        <table class="table table-bordered table-striped" id="">
                            <thead>
                                <tr>
                                    <th colspan="4" class="text-center">Member Payments</th>
                                </tr>
                                <tr>
                                    <th>Sr</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($member->payments as $key=>  $payment)

                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td scope="row">{{ $payment->date }}</td>
                                    <td scope="row">{{ $payment->description }}</td>
                                    <td scope="row">{{ formatAmount($payment->amount) }}</td>


                                </tr>


                                <!-- Modal -->

                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>{{ formatAmount($member->payments()->sum('amount')) ?? 0 }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid end -->

</div>

@endsection
