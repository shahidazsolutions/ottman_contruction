@extends('layouts.app')
@section('content')
<div>

    <div class="page-body">
        <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-header-left">
                            <h3>Add Transfer
                                <small>Welcome to admin panel</small>
                            </h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid end -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between">
                            <h5>Add Transfer</h5>

                            <a href="{{ route('form.transfer.index') }}" class="btn btn-dashed btn-pill color-4">Transfer Forms</a>
                        </div>
                        <div class="card-body">

                            <form class="row gx-3" action="{{ route('form.transfer.form') }}" method="POST" id="transferForm">
                                @csrf
                                <div class="container">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="">Select Party A <span class="text-danger">*</span></label>
                                            <select name="customer_a" class="form-control party-a" required id="partyA">
                                                <option value="">Select party A </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_a')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Select Flat<span class="text-danger">*</span></label>
                                            <select name="flat" class="form-control" required id="flat">
                                                <option value="">Select Flat</option>

                                            </select>
                                            @error('flat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Select Party B <span class="text-danger">*</span></label>
                                            <select name="customer_b" class="form-control party-b" required id="partyB">
                                                <option value="">Select party B </option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('customer_b')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="mt-2 btn btn-primary float-end">Submit</button>
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

</div>
@push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#partyA').change(function() {
                var selectedValue = $(this).val();
                $('.party-b option').prop('disabled', false); // Enable all options first
                $('.party-b option[value="' + selectedValue + '"]').prop('disabled', true); // Disable the selected option in party B
            });


            $('#partyA').change(function() {
            var customerId = $(this).val();

            $.ajax({
                url: "{{ route('form.transfer.flat', ':customerId') }}".replace(':customerId', customerId),
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    // Clear existing options
                    $('#flat').empty();

                    // Populate select box with fetched projects
                    $.each(response, function(key, value) {
                        $('#flat').append('<option value="' + value.id + '">' + value.room_number +value.floor_number  +'</option>');
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
        });
    </script>
@endpush
@endsection
