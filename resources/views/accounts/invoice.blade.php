@extends('layouts.app')

@section('content')

<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>INVOICE
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
                        <h5>Create Invoice</h5>
                    </div>

                    <div class="card-body">
                        <form id="form">
                            <div class="container">
                                <div class="row">


                                    <div class="col-md-6">
                                        <label for="">Select Type <span class="text-danger">*</span> </label>
                                        <select class="form-control" name="type" id="">
                                            <option value="">Select type </option>
                                            <option value="contractors">Contractor</option>
                                            <option value="suppliers">Supplier</option>
                                            <option value="expense">Expense</option>
                                        </select>

                                    </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6" style="display: none;" id="suppliers">
                                        <label for="">Select Supplier <span class="text-danger">*</span> </label>
                                        <select name="supplier_id" class="form-control" id="">
                                            <option value="">Select Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6" style="display: none;" id="contractors">
                                        <label for="">Select Contractor <span class="text-danger">*</span> </label>
                                        <select name="contractor_id" class="form-control" id="">
                                            <option value="">Select Contractor</option>
                                            @foreach ($contractors as $contractor)
                                            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                </div>
                            </div>


                        </form>

                    </div>


                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Order ID </th>
                                <th>Project</th>
                                <th>Payment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
            $('select[name=type]').change(function(){
                var type = $(this).val();
                if(type=='suppliers'){
                    $('#contractors').hide();
                    $('#suppliers').show();
                }else if(type=='contractors'){
                    $('#contractors').show();
                    $('#suppliers').hide();

                }else{
                    $('#contractors').hide();
                    $('#suppliers').hide();

                }
            });

            // invoice
            var token = document.getElementsByName("csrfToken").value;

            $(document).on('change','select[name=contractor_id]',function(){
                contractor_id = $(this).val();
                if(contractor_id!=""){
                    $.ajax({
                        url:'{{ route('account.invoice.data') }}',
                        data:{contractor_id:contractor_id,type:'contractor'},
                        type:"GET",

                        headers: {
                    'X-CSRF-Token': token
               },

               success: function (data) {
                console.log(data);
                },
      error: function (data) {
        console.log(data);

      }
                    });
                }
            });




            $(document).on('change','select[name=supplier_id]',function(){
                supplier_id = $(this).val();

                if(supplier_id!=""){
                    $.ajax({
                        url:'{{ route('account.invoice.data') }}',
                        data:{supplier_id:supplier_id,type:'supplier'},
                        type:"GET",

                        headers: {
                    'X-CSRF-Token': token
               },

               success: function (data) {
                console.log(data);
                },
      error: function (data) {
        console.log(data);

      }
                    });
                }
            });



        });
</script>

@endsection
