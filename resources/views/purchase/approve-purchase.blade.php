@extends('layouts.app')
@section('content')
<div class="page-body">
    <!-- Container-fluid start -->
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-header-left">
                    <h3>Purchase
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
                <div class="card-header pb-0">
                    <h5>Add Purchase  </h5>
                </div>

                <div class="card-body admin-form">

                    <div class="row gx-3 mb-3">
                        <div class="form-group col-sm-4 selectProject">
                            <label>Projects</label>
                            <select class="form-select">
                                <option selected value="" disabled>Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{$project->id}}">{{$project->project_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4 selectSupplier d-none">
                            <label>Project Suppliers</label>
                            <select class="form-select">
                                {{-- // From JS --}}
                            </select>
                        </div>
                        <div class="form-group col-sm-4 selectSupplierOrder d-none">
                            <label>Orders</label>
                            <select class="form-select">
                                {{-- // From JS --}}
                            </select>
                        </div>
                    </div>

                    <form class="row gx-3 dnone">
                        <hr class="mb-4">

                        <div class="form-group col-sm-4">
                            <label>Change Supplier</label>
                            <select class="form-select">
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Project</label>
                            <select class="form-select">
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Requistion Date</label>
                            <select class="form-select">
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Required Date</label>
                            <select class="form-select">
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Remark</label>
                            <select class="form-select">
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Image</label>
                            <input type="file" disabled class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @endif
                        </div>
                        {{-- Requistion Items --}}

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('change',".selectProject select", function(){
        let url = "{{ route('purchase.select-project') }}";
        $.ajax({
            url: url,
            method:"POST",
            data:{
                project: $(this).val(),
                _token: "{{ csrf_token()  }}"
            },
            success: function(res){
                if(res.success == "suppliers"){
                    $(".selectSupplier").removeClass('d-none');
                    $(".selectSupplier select").html(`<option selected value="" disabled>Select Supplier</option>`);
                    if(res.supplier){
                        for( let key in res.supplier ){
                            $(".selectSupplier select").append(`
                            <option value="${key}">${res.supplier[key]['name']} ${res.supplier[key]['fname']}</option>`);
                        }
                    }else{
                        $(".selectSupplier select").html(`<option selected value="" disabled>Supplier Not Found</option>`);
                    }
                }
            }
        })
    })
    $(document).on('change',".selectSupplier select", function(){
        let url = "{{ route('purchase.select-supplier') }}";
        $.ajax({
            url: url,
            method:"POST",
            data:{
                project: $(".selectProject select").val(),
                supplier: $(".selectSupplier select").val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(res){
                console.log(res);
                if(res.success == "success"){
                    $(".selectSupplierOrder").removeClass('d-none');
                    $(".selectSupplierOrder select").html(`<option selected value="" disabled>Select Order Number</option>`);
                    if(res.supplier){
                        for( let key in res.supplier ){
                            $(".selectSupplierOrder select").append(`
                            <option value="${key}">${res.supplier[key]['r_id']}</option>`);
                        }
                    }else{
                        $(".selectSupplierOrder select").html(`<option selected value="" disabled>No Order Found</option>`);
                    }
                }
            }
        })
    })

    // Requistions
    $(document).ready(function(){
        @isset($item_count)
        for (var e = 0; e < {{$item_count}}; e++) {
            var quantity = $("#quantity"+e).val();
            // alert(quantity);
            var rate = $("#rate"+e).val();
            var total = quantity*rate;
            $("#total"+e).text(total);
        }
        updateTotal();
        @endisset
    });
    function updateTotal() {
        var grandTotal = 0;
        $('.total').each(function(){
            grandTotal += parseFloat($(this).text());
        });
        $('#total_amount .h2').text(grandTotal);
        $('#total_amount_hidden').val(grandTotal);
    }

</script>

@endsection
