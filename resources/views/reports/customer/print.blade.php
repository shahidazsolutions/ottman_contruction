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
                        <h3>Customer Payments
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
            @isset($record)
            <div class="col-12 text-center">
                <h2>Customer Report</h2>
            </div>
            <div class="col text-center">
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
            </div>
            @foreach ($record as $val)

            <div class="col-12 my-3 ps-4">
                <strong>Customer Name : {{ $customer_detail->name }}</strong>
                    <br>
                    <strong>Phone Number : {{ $customer_detail->mobile_number }}</strong>
                        <br>
                        <strong>Flat No : {{ $val->flate->room_number.$val->flate->floor_number }}</strong>
                            <br>
                            @php

                            $advance = 0;
                            $prevoise_paid = 0;
                            @endphp
                            @if ($transfer==1)

                            <strong>Flat Total Price : {{
                                $val->getBooking($val->old_customer_id,$val->flat_id)->total_amount }}</strong>
                            <br>

                            <strong>Previous Paid : {{

                      $prevoise_paid =   App\Models\Customer::prevoicePaid($val->old_customer_id,$val->flat_id) }}</strong>
                            <br>


                            @else

                            <strong>Flat Total Price : {{ $val->total_amount }}</strong>

                            <br>
                            <strong>Advance Payment : {{ $val->paid_amount }}</strong>

                            <br>

                            @php

                            $advance =$val->paid_amount;
                            @endphp


                            @endif

            </div>

            <div class="col-12">





                <table class="table table-hover table-bordered ">
                    <thead>
                        <tr>
                            <th>Payment Id</th>
                            <th>Date</th>
                            <th>Amount</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $total=0;
                        $paid_amount=0;
                        @endphp


                        @foreach ($val->customerPayment($customer_detail->id,$val->flat_id) as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->date }}</td>
                            <td>{{ $payment->amount }}</td>
                        </tr>
                        @php
                        $paid_amount += $payment->amount;
                        @endphp
                        @endforeach
                    </tbody>
                    <tr>
                        <td colspan="2">Flat Price</td>
                        @if($transfer==1)
                        <td>{{ $val->getBooking($val->old_customer_id,$val->flat_id)->total_amount }}</td>

                        @else

                        <td>{{ $val->total_amount }}</td>
                        @endif

                    </tr>
                    <tr>
                        <td colspan="2">Total Paid</td>
                        <td>{{ $paid_amount + $advance + $prevoise_paid}}</td>
                    </tr>

                    <tr>
                        <th colspan="2">Remaining</th>

                        @if($transfer==1)
                        <th>{{ $val->getBooking($val->old_customer_id,$val->flat_id)->total_amount - $paid_amount -$prevoise_paid }}
                        </th>

                        @else

                        <th>{{ $val->total_amount - $paid_amount - $advance }}</th>

                        @endif


                    </tr>

                </table>
            </div>
            @endforeach

            @endisset
        </div>
    </div>
</div>




<script>
    $(document).ready(function(){

            // invoice

        // get project
        $('select[name=customer_id]').change(function() {
            var customerId = $(this).val();

            $.ajax({
                url: "{{ route('customer.payments.project', ':customerId') }}".replace(':customerId', customerId),
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    // Clear existing options
                    $('#project').empty();

                    // Populate select box with fetched projects
                    $('#project').html(`
                    <option value="">Select project</option>
                    `);

                    $.each(response, function(key, value) {
                        $('#project').append('<option value="' + value.id + '">' + value.project_name  +'</option>');
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });


        $(document).on('change', 'select[name=customer_id], select[name=project_id]', function() {
    var customerId = $('select[name=customer_id]').val();
    var projectId = $('select[name=project_id]').val();

        if(customerId!="" && projectId!=""){

            $.ajax({
                url: "{{ route('customer.payments.flat', ['customerId' => ':customerId', 'project_id' => ':projectId']) }}"
                .replace(':customerId', customerId)
                .replace(':projectId', projectId),
        type: 'GET',
        success: function(response) {
            console.log(response);
            // Clear existing options
            $('#flat').empty();

            // Populate select box with fetched projects
            $.each(response, function(key, value) {
                $('#flat').append('<option value="' + value.id + '">' + value.room_number + value.floor_number + '</option>');
            });
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}else{
    $('#flat').html(`
                    <option value="">Select flat</option>
                    `);

}
});






        });
</script>

@endsection
