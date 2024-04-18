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
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h5>Contractor Payment Report</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('report.contractor.payment.print') }}" method="POST">
                            @csrf
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="">Select Contractor <span class="text-danger">*</span> </label>
                                    <select name="contractor_id" class="form-control" id="">
                                        <option value="">Select Contractor</option>
                                        @foreach ($contractors as $contractor)
                                        <option {{ (isset($contractor_detail) && $contractor->id==$contractor_detail->id)?"selected":"" }}  value="{{ $contractor->id }}">{{ $contractor->name }}</option>
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
                                    <input type="submit" name="print" class="btn btn-primary float-end">
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
        $('select[name=contractor_id]').change(function() {
            var contractorId = $(this).val();
        
            $.ajax({
                url: "{{ route('report.contractor.payments.project', ':contractorId') }}".replace(':contractorId', contractorId),
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




        });
</script>

@endsection
