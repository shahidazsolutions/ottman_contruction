@extends('layouts.app')

@section('content')
<style>
    .logo{
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card border">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h5>Customer Payment Report</h5>
                        {{-- <a href="{{ route('customer.payments.create') }}" class="btn btn-primary float-end">Add
                            Payment</a> --}}

                    </div>

                    <div class="card-body">
                        <form action="{{ route('report.customer.payment.print') }}" method="POST">
                            @csrf
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="">Select Customer <span class="text-danger">*</span> </label>
                                    <select name="customer_id" class="form-control" id="">
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                        <option {{ (isset($customer_detail) && $customer->id==$customer_detail->id)?"selected":"" }}  value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-md-6">
                                    <label for="">Select Project <span class="text-danger">*</span> </label>
                                    <select  class="form-control" name="project_id" id="project">
                                        <option value="">Select Project</option>

                                    </select>
                                    @error('project_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>



                                <div class="col-12">
                                    <label for="">Select flat <span class="text-danger">*</span> </label>
                                    <select class="form-control" name="flat_id" id="flat">
                                        <option value="">Select flat </option>

                                    </select>
                                    @error('flat_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="col-12">
                                    <input type="submit" name="print" class="btn btn-primary float-end">
                                </div>
                            </div>

                        </form>



                    </div>


                </div>
            </div>

        </div>

        {{-- <div class="row bg-white">
            @isset($record)
            <div class="col-12 text-center">
                <h2>Customer Report</h2>
            </div>
            <div class="col text-center">
                <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
            </div>
            @foreach ($record as $val)

            <div class="col-12 my-3 ps-4">
                <strong>Customer Name : {{ $customer_detail->name }}</stro>
                    <br>
                    <strong>Phone Number : {{ $customer_detail->mobile_number }}</stro>
                        <br>
                <strong>Flat No : {{ $val->flate->room_number.$val->flate->floor_number }}</stro>
                    <br>
                <strong>Flat Total Price : {{ $val->total_amount }}</stro>
                    <br>
                <strong>Flat Installment Price : {{ $val->installment }}</stro>
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
                      @foreach ($val->customerPayment($val->customer_id,$val->flat_id) as $payment)
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
                        <td>{{ $val->total_amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total Paid</td>
                        <td>{{ $paid_amount }}</td>
                    </tr>

                    <tr>
                        <th colspan="2">Remaining</th>
                        <th>{{ $val->total_amount - $paid_amount }}</th>
                    </tr>

                </table>
            </div>
            @endforeach

            @endisset
        </div> --}}
    </div>
</div>




<script>
    $(document).ready(function(){

            // invoice

        // get project
        $('select[name=customer_id]').change(function() {
            var customerId = $(this).val();

            $.ajax({
                url: "{{ route('report.customer.payments.project', ':customerId') }}".replace(':customerId', customerId),
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    // Clear existing options
                    $('#project').empty();

                    // Populate select box with fetched projects
                    $('#project').html(`
                    <option value="">Select Project</option>
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
                url: "{{ route('report.customer.payments.flat', ['customerId' => ':customerId', 'project_id' => ':projectId']) }}"
                .replace(':customerId', customerId)
                .replace(':projectId', projectId),
        type: 'GET',
        success: function(response) {
            console.log(response);
            // Clear existing options
            $('#flat').empty();
            $('#flat').html(`
                    <option value="">Select Flat</option>
                    `);
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
