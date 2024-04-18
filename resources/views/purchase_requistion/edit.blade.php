@extends('layouts.app')

@section('content')




    <div class="page-body">
            <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-header-left">
                            <h3>Purchase Requisition
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
                        @if($purchase == "2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q")
                        @else
                        <div class="card-header pb-0">
                            <h5>Update Purchase Requisition </h5>
                        </div>
                        @endif
                        <input type="hidden" name="secert__id" value="2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q">
                        <div class="card-body admin-form">
                            <form class="row gx-3" method="POST" action="@if($purchase == "2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q") {{route('purchase-requistion.update',$purchase_requistion->id) }}/2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q @else {{route('purchase-requistion.update',$purchase_requistion->id) }} @endif" enctype="multipart/form-data">
                                @csrf
                                @if($purchase == "2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q")

                                @else
                                    <div class="form-group col-sm-4">
                                        <label>Project </label>
                                        <select class="form-select" name="project_id" id="">
                                            <option selected value="">Select Project</option>
                                            @foreach ($project as $item)
                                                <option value="{{$item->id}}" @selected($purchase_requistion->project_id == $item->id)>{{$item->project_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <span class="text-danger">The project name field is required.</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Supplier</label>
                                        <select class="form-select" name="supplier_id" id="">
                                            <option selected value="">Select Contractor</option>
                                            @foreach ($supplier as $men)
                                                <option value="{{$men->id}}" @selected($purchase_requistion->supplier_id == $men->id)>{{$men->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="text-danger">Select the supplier.</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Requistion Date</label>
                                        <input type="date" class="form-control @error('requistion_date') is-invalid @enderror" name="requistion_date" value="{{ $purchase_requistion->requistion_date}}">
                                        @error('requistion_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Required Date</label>
                                        <input type="date" class="form-control @error('required_date') is-invalid @enderror" name="required_date" value="{{ $purchase_requistion->required_date }}">
                                        @error('required_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Remark (Optional)</label>
                                        <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{ $purchase_requistion->remark }}">
                                        @error('remark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Image (Optional)</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                @endif

                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5>Requistion Items</h5>
                                    </div>
                                    <div class="card-body admin-form" id="item">
                                        @foreach($purchase_requistion_item as $key => $data)
                                        <div class="row row_{{$key}}" id="{{$key}}">
                                            <div class="col-sm-2">
                                                <label>Item </label>
                                                <select class="form-select" name="item_id[]" id="">
                                                    <option selected value="">Select </option>
                                                    @foreach ($items as $item)
                                                        <option value="{{$item->id}}" @selected($data->item_id == $item->id)>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('item_id')
                                                    <span class="text-danger">The Item field is required.</span>
                                                @endif
                                            </div>
                                            <input type="hidden" name="p_id{{$key}}" value="{{$data->id}}">
                                            <input type="hidden" name="row_item_id[]" value="{{$data->id}}">

                                            <div class=" col-sm-2">
                                                <label>Unit </label>
                                                <select class="form-select" name="unit_id[]" id="">
                                                    <option selected value="">Select </option>

                                                    @foreach ($unit as  $item)
                                                        <option value="{{$item->id}}" @selected($data->unit_id == $item->id)>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
                                                    <span class="text-danger">The unit  field is required.</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Quantity </label>
                                                <input type="number" step="any" class="form-control @error('quantity') is-invalid @enderror" id="quantity{{$key}}" value="{{ $data->quantity }}" name="quantity[]" onkeyup="multiply({{$key}})">
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Rate </label>
                                                <input type="number" step="any" class="form-control @error('rate') is-invalid @enderror " value="{{ $data->rate }}" id="rate{{$key}}"  name="rate[]" onkeyup="multiply({{$key}})">
                                                @error('rate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Total </label>

                                                <h2 id="total{{$key}}" class="total">0</h2>
                                            </div>
                                            @if($key == 0 )
                                                <div class=" col-sm-2">
                                                    <button type="button" class="btn btn-primary add_item_input">+</button>
                                                </div>
                                            @else
                                                <div class=" col-sm-2" style="display:flex;align-items:center;">
                                                    <button type="button" class="btn btn-danger" onclick="delete_button({{$key}})">-</button>
                                                    <input type="hidden" class="id_{{$key}}" value="{{$data->id}}">
                                                </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class=" col-sm-12">
                                        <h3 id="total_amount" >Total Amount <span class="h2" >0 </span></h3>
                                        <input type="hidden" step="any" id="total_amount_hidden" value="{{old('amount')}}" name="amount">
                                        @error('amount')
                                            <span class="text-danger">Invalid Amount</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-btn col-sm-12">
                                    <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4 px-4">Update</button>
                                    @if($purchase == "2y10157tj6zKdfsvWi3mNuOUeBaQg55796upwcOxy7bgdYsBam5nH19q")
                                    <button
                                        type="button"
                                        class="btn btn-pill btn-gradient color-4 px-4"
                                        onclick="history.back()">
                                        Back To Purchase
                                    </button>
                                    {{-- <button
                                        type="button"
                                        class="btn btn-pill btn-gradient color-4 px-4"
                                        onclick="window.location='{{route('purchase.add')}}'">
                                        Back To Purchase
                                    </button> --}}
                                    @else
                                    @endif
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
            for (var e = 0; e < {{$item_count}}; e++) {
                var quantity = $("#quantity"+e).val();
                // alert(quantity);
                var rate = $("#rate"+e).val();
                var total = quantity*rate;
                $("#total"+e).text(total);
            }
            updateTotal();

            var numid=50;
            $(".add_item_input").click(function(){
                var datanum =  numid++;
                var data = `<div class="row" >
                    <div class="col-sm-2">

                        <label>Item </label>
                        <select class="form-select" name="item_id[]" >
                            <option selected value="">Select </option>
                            @foreach ($items as $item)
                                <option value="{{$item->id}}" @selected(old('item_id') == $item->id)>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <span class="text-danger">The Item field is required.</span>
                        @endif
                    </div>
                    <input type="hidden" name="row_item_id[]" value="">
                    <div class=" col-sm-2">
                        <label>Unit </label>
                        <select class="form-select" name="unit_id[]" id="">
                            <option selected value="">Select </option>
                            @foreach ($unit as $item)
                                <option value="{{$item->id}}" @selected(old('unit_id') == $item->id)>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <span class="text-danger">The unit  field is required.</span>
                        @endif
                    </div>
                    <div class=" col-sm-2">
                        <label>Quantity </label>
                        <input type="text" step="any" class="form-control @error('quantity') is-invalid @enderror quantity" value="{{ old('quantity.0') }}" name="quantity[]" onkeyup="multiply(${datanum})" id="quantity${datanum}">
                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @endif
                    </div>
                    <div class=" col-sm-2">
                        <label>Rate </label>
                        <input type="text" step="any" class="form-control @error('rate') is-invalid @enderror rate" value="{{ old('rate.0') }}" name="rate[]" id="rate${datanum}" onkeyup="multiply(${datanum})">
                        @error('rate')
                            <span class="text-danger">{{ $message }}</span>
                        @endif
                    </div>
                    <div class=" col-sm-2">
                        <label>Total </label>

                        <h2 id="total${datanum}" class="total">0</h2>
                    </div>
                    <div class=" col-sm-2" style="display:flex;align-items:center;">
                        <button type="button" class="btn btn-danger delete_item_input">-</button>
                    </div>
                </div>`;
                $('#item').append(data);
                $(".delete_item_input").click(function(){
                    // alert("as");
                    $(this).parent().parent().remove();
                });
            });
            // $(document).on("click",".add_item_input",function(e){
            //     e.preventDefault();
        	//     // var data_id=$(".id_"+id).val();
            //     //
            //     $.ajax({
            //         url: "{{route('purchase-requistion.add-requistion-list')}}",
            //         method: "POST",
            //         data: {act:"act"},
            //         success: function(res){
            //             console.log(res);
            //         }
            //     })
            // })
        });

        function multiply(e) {
    var quantity = parseFloat($("#quantity"+e).val()) || 0;
    var rate = parseFloat($("#rate"+e).val()) || 0;
    var total = quantity * rate;
    $("#total"+e).text(total.toFixed(2)); // Format total with 2 decimal places
    updateTotal();
}

function updateTotal() {
    var grandTotal = 0;
    $('.total').each(function() {
        grandTotal += parseFloat($(this).text()) || 0;
    });
    $('#total_amount .h2').text(grandTotal.toFixed(2)); // Format grand total with 2 decimal places
    $('#total_amount_hidden').val(grandTotal.toFixed(2)); // Set hidden field value with 2 decimal places
}




        function delete_button(id) {
        //    alert("e");
    	    var data_id=$(".id_"+id).val();
            // alert(data_id);
    	    $.ajax({
    	        url:"{{route('purchase-requistion.delete_item')}}",
    	        method:"GET",
    	        data:{
                    data_id:data_id,
                    _token:"{{csrf_token()}}"
                },
                success:function(res){
                    console.log(res)
                    $(".row_"+id).remove();
                    updateTotal();
                }
    	    });
        }
    </script>


@endsection
