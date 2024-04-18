@extends('layouts.app')

@section('content')

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
                    <div class="card-header pb-0">
                        <h5>Create Payment</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('customer.payments.store') }}" method="post">
                            @csrf
                            <div class="container">

                                <div class="row g-3">
                                    <div class="col-md-6" id="customers">
                                        <label for="">Select Customer <span class="text-danger">*</span> </label>
                                        <select name="customer_id" class="form-control" id="">
                                            <option value="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Select Project <span class="text-danger">*</span> </label>
                                        <select class="form-control" name="project_id" id="project">
                                            <option value="">Select project </option>

                                        </select>
                                        @error('project_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>


                                    <div class="col-md-6">
                                        <label for="">Select flat <span class="text-danger">*</span> </label>
                                        <select class="form-control" name="flat_id" id="flat">
                                            <option value="">Select flat </option>

                                        </select>
                                        @error('flat_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>


                                    <div class="col-md-6">
                                        <label for="">Date <span class="text-danger">*</span> </label>
                                        <input type="date" value="{{ old('date') }}" class="form-control" name="date" required>
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>



                                    <div class="col-md-6">
                                        <label for="">Amount <span class="text-danger">*</span> </label>
                                        <input type="number" value="{{ old('amount') }}" class="form-control" placeholder="Enter amount" name="amount" required>
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-12">
                                        <label for="">Description</label>
                                        <textarea name="description" placeholder="description" class="form-control" id="" cols="30" rows="3">{{ old('desccription') }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary float-end">
                                    </div>



                                </div>
                            </div>

                        </form>

                    </div>


                </div>
            </div>

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




            $('#form').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
               $.ajax({
                type: 'GET', // or 'GET' depending on your server-side handling
                 url: "{{ route('invoice') }}",
                data: formData,
                success: function(response) {

                },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error submitting form:', error);
            }
                });

            });

        });
</script>

@endsection
