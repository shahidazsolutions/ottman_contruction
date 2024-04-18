@extends('layouts.app')

@section('content')

<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Contractor Payments
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
                        <form action="{{ route('contractor.payments.store') }}" method="post">
                            @csrf
                            <div class="container">
                                {{-- <div class="row">


                                    <div class="col-md-6">
                                        <label for="">Select Type <span class="text-danger">*</span> </label>
                                        <select class="form-control" name="type" id="">
                                            <option value="">Select type </option>
                                            <option value="contractors">Contractor</option>
                                            <option value="suppliers">Supplier</option>
                                            <option value="expense">Expense</option>
                                        </select>

                                    </div>


                                </div> --}}
                                <div class="row g-3">
                                    <div class="col-md-6" id="suppliers">
                                        <label for="">Select Contractor <span class="text-danger">*</span> </label>
                                        <select name="contractor_id" class="form-control" id="">
                                            <option value="">Select Contractor</option>
                                            @foreach ($contractors as $contractor)
                                            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('contractor_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>


                                    <div class="col-md-6">
                                        <label for="">Select Project <span class="text-danger">*</span> </label>
                                        <select class="form-control" name="project_id" id="">
                                            <option value="">Select project </option>

                                        </select>
                                        @error('project_id')
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
                                        <input type="number" value="{{ old('amount') }}" class="form-control"  placeholder="Enter amount" name="amount" required>
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-12">
                                        <label for="">Description</label>
                                        <textarea name="description" placeholder="description" class="form-control" id="" cols="30" rows="3">{{ old('desccription') }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <input type="submit" value="Submit" class="btn btn-primary float-end">
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

            $(document).on('change','select[name=contractor_id] ',function(){
                contractor_id = $(this).val();


                    if(contractor_id!=""){


                $.ajax({
                    url: "{{ route('contractor.payments.get_project') }}",
                    data: {contractor_id: contractor_id},
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        if(response.status == 1){
                            var projects = response.data; // Assuming response.data is an array of projects

                            // Clear previous options
                            $('select[name=project_id]').empty();

                            // Append new options based on received projects
                            $.each(projects, function(index, project) {
                                $('select[name=project_id]').append('<option value="' + project.id + '">' + project.project_name + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error retrieving projects:', error);
                    }
                });

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
