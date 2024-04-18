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
                        <h5>Supplier Payment Report</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('report.supplier.payment.print') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="">Select Supplier <span class="text-danger">*</span> </label>
                                    <select name="supplier_id" class="form-control" id="">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                        <option {{ (isset($supplier_detail) && $supplier->id==$supplier_detail->id)?"selected":"" }}  value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
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
                                    <input type="submit" value="submit" class="btn btn-primary float-end">
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
        // get project
        $('select[name=supplier_id]').change(function() {
            var supplierId = $(this).val();
            $.ajax({
                url: "{{ route('report.supplier.payments.project', ':supplierId') }}".replace(':supplierId', supplierId),
                type: 'GET',
                success: function(response) {
                    // Clear existing options
                    $('#project').empty();
                    // Populate select box with fetched projects
                    $('#project').html(`<option value="">Select Project</option>`);
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
