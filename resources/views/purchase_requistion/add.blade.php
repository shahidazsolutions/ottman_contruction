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
                        <div class="card-header pb-0">
                            <h5>Add Purchase Requisition </h5>
                        </div>

                        <div class="card-body admin-form">
                            <form class="row gx-3" method="POST" action="{{route('purchase-requistion.insert') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-4">
                                    <label>Project  <span class="text-danger">*</span> </label>
                                    <select class="form-select" name="project_id" id="">
                                        <option selected value="">Select Project</option>
                                        @foreach ($project as $item)
                                            <option value="{{$item->id}}" @selected(old('project_id') == $item->id)>{{$item->project_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Supplier</label>
                                    <select class="form-select" name="supplier_id" id="">
                                        <option selected value="">Select Supplier</option>
                                        @foreach ($supplier as $men)
                                            <option value="{{$men->id}}" @selected(old('supplier_id') == $men->id)>{{$men->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="text-danger">The project name field is required.</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Requistion Date</label>
                                    <input type="date" class="form-control @error('requistion_date') is-invalid @enderror" name="requistion_date" value="{{ old('requistion_date') }}">
                                    @error('requistion_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Required Date</label>
                                    <input type="date" class="form-control @error('required_date') is-invalid @enderror" name="required_date" value="{{ old('required_date') }}">
                                    @error('required_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Remark (Optional)</label>
                                    <input type="text" class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{ old('remark') }}">
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

                                {{-- Start Cards  --}}
                                <div class="card">
                                    <div class="card-header pb-0">
                                        <h5>Requistion Items</h5>
                                    </div>
                                    <div class="card-body admin-form" id="item">
                                        <div class="row item-row" >
                                            <div class="col-sm-2">
                                                <label>Item </label>
                                                <select class="form-select" name="item_id[]" id="" value="{{old('item_id.0')}}">
                                                    <option selected value="" disabled>Select</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('item_id')
                                                    <span class="text-danger">The Item field is required.</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Unit </label>
                                                <select class="form-select" name="unit_id[]" id=""value="{{old('unit_id.0')}}">
                                                    <option selected value="" disabled>Select </option>
                                                    @foreach ($unit as $units)
                                                        <option value="{{$units->id}}"  > {{$units->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
                                                    <span class="text-danger">The unit  field is required.</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Quantity </label>
                                                <input type="number" step="any" class="form-control quantity   @error('quantity') is-invalid @enderror" id="quantity0" value="" name="quantity[]" onkeyup="multiply()">
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Rate </label>
                                                <input type="number" step="any" class="form-control rate @error('rate') is-invalid @enderror " value="" id="rate0"  name="rate[]" onkeyup="multiply()">
                                                @error('rate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Total </label>
                                                <h2 id="total0" class="total"></h2>
                                            </div>

                                            <div class="col-sm-2" style="display: inline-flex; align-items: center;">
                                                <button type="button" class="btn btn-primary add_item_input">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" col-sm-12">
                                        <h3 id="total_amount" >Total Amount <span class="h2" ></span></h3>
                                        <input type="hidden" step="any" id="total_amount_hidden" value="" name="amount">
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                </div>
                                {{-- End Cards  --}}

                                <div class="form-btn col-sm-12">
                                    <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Create</button>
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
            var numid=1;
            $(".add_item_input").click(function(){
              var datanum =  numid++;
                var data = `<div class="row item-row" >
                <div class="col-sm-2">

                    <label>Item </label>
                    <select class="form-select" name="item_id[]" id="${datanum}" value="{{old('item_id.${datanum}')}}">
                        <option selected value="">Select </option>
                        @foreach ($items as $item)
                            <option value="{{$item->id}}" @selected(old('item_id.${datanum}') == $item->id)>{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('item_id.${datanum}')
                        <span class="text-danger">The Item field is required.</span>
                    @endif
                </div>
                <div class=" col-sm-2">
                    <label>Unit </label>
                    <select class="form-select" name="unit_id[]" id="" value="{{old('unit_id.${datanum}')}}>
                        <option selected value="">Select </option>
                        @foreach ($unit as $item)
                            <option value="{{$item->id}}" @selected(old('unit_id.${datanum}') == $item->id)>{{$item->name}}</option>
                        @endforeach
                    </select>
                    @error('unit_id.${datanum}')
                        <span class="text-danger">The unit  field is required.</span>
                    @endif
                </div>
                <div class=" col-sm-2">
                    <label>Quantity </label>
                    <input type="text" step="any" class="form-control @error('quantity') is-invalid @enderror quantity" value="{{ old('quantity.${datanum}') }}" name="quantity[]" onkeyup="multiply()" id="quantity${datanum}">
                    @error('quantity.${datanum}')
                        <span class="text-danger">{{ $message }}</span>
                    @endif
                </div>
                <div class=" col-sm-2">
                    <label>Rate </label>
                    <input type="text" step="any" class="form-control rate @error('rate') is-invalid @enderror rate" value="{{ old('rate.${datanum}') }}" name="rate[]" id="rate${datanum}" onkeyup="multiply()">
                    @error('rate.${datanum}')
                        <span class="text-danger">{{ $message }}</span>
                    @endif
                </div>
                <div class=" col-sm-2">
                    <label>Total </label>

                    <h2 id="total${datanum}" class="total">0</h2>
                </div>
                <div class=" col-sm-2" style="display: inline-flex; align-items: center;">
                    <button type="button" class="btn btn-danger delete_item_input">-</button>
                </div>
                </div>`;
                $('#item').append(data);
                $(".delete_item_input").click(function(){
                    $(this).parent().parent().remove();
                    multiply();
                });
            });
            // $(document).on("click",".add_item_input",function(e){
            //     e.preventDefault();
            //     // alert("okay")
        	//     // var data_id=$(".id_"+id).val();
            //     $.ajax({
            //         url: "{{route('purchase-requistion.add-requistion-list')}}",
            //         method: "GET",
            //         data: {act:"act"},
            //         success: function(res){
            //             // console.log(res[0]['id']+1);
            //             console.log(res);

            //             // var data = `<div class="row" >
            //             //     <div class="col-sm-2">
            //             //         <label>Item </label>
            //             //         <select class="form-select" name="item_id[]" id="${datanum}" value="{{old('item_id.${datanum}')}}">
            //             //             <option selected value="">Select </option>
            //             //             @foreach ($items as $item)
            //             //                 <option value="{{$item->id}}" @selected(old('item_id.${datanum}') == $item->id)>{{$item->name}}</option>
            //             //             @endforeach
            //             //         </select>
            //             //     </div>
            //             //     <div class=" col-sm-2">
            //             //         <label>Unit </label>
            //             //         <select class="form-select" name="unit_id[]" id="" value="{{old('unit_id.${datanum}')}}>
            //             //             <option selected value="">Select </option>
            //             //             @foreach ($unit as $item)
            //             //                 <option value="{{$item->id}}" @selected(old('unit_id.${datanum}') == $item->id)>{{$item->name}}</option>
            //             //             @endforeach
            //             //         </select>
            //             //         @error('unit_id.${datanum}')
            //             //             <span class="text-danger">The unit  field is required.</span>
            //             //         @endif
            //             //     </div>
            //             //     <div class=" col-sm-2">
            //             //         <label>Quantity </label>
            //             //         <input type="text" class="form-control @error('quantity') is-invalid @enderror quantity" value="{{ old('quantity.${datanum}') }}" name="quantity[]" onkeyup="multiply(${datanum})" id="quantity${datanum}">
            //             //         @error('quantity.${datanum}')
            //             //             <span class="text-danger">{{ $message }}</span>
            //             //         @endif
            //             //     </div>
            //             //     <div class=" col-sm-2">
            //             //         <label>Rate </label>
            //             //         <input type="text" class="form-control @error('rate') is-invalid @enderror rate" value="{{ old('rate.${datanum}') }}" name="rate[]" id="rate${datanum}" onkeyup="multiply(${datanum})">
            //             //         @error('rate.${datanum}')
            //             //             <span class="text-danger">{{ $message }}</span>
            //             //         @endif
            //             //     </div>
            //             //     <div class=" col-sm-2">
            //             //         <label>Total </label>

            //             //         <h2 id="total${datanum}" class="total">0</h2>
            //             //     </div>
            //             //     <div class=" col-sm-2" style="display: inline-flex; align-items: center;">
            //             //         <button type="button" class="btn btn-danger delete_item_input">-</button>
            //             //     </div>
            //             // </div>`;
            //             // console.log(res);
            //             // $('#item').append("<pre>"+res+"</pre>");
            //         }
            //     })
            // })
        });
    //     function multiply(e){
    //             var quantity = $("#quantity"+e).val();
    //             // alert(quantity);
    //             var rate = $("#rate"+e).val();
    //             var total = quantity*rate;
    //             $("#total"+e).text(total);
    //             updateTotal();
    //     }
    //     function updateTotal() {
    //         var grandTotal = 0;
    //         $('.total').each(function(){
    //             grandTotal += parseFloat($(this).text());
    //         });
    //         $('#total_amount .h2').text(grandTotal);
    //         $('#total_amount_hidden').val(grandTotal);
    //   }


    function multiply() {
    var total = 0;
    $('.item-row').each(function() {
        var qty = parseFloat($(this).closest('div').find('.quantity').val()) || 0;
        var rate = parseFloat($(this).closest('div').find('.rate').val()) || 0;
        var subtotal = qty * rate;

        // Format subtotal with 2 decimal places
        var formattedSubtotal = subtotal.toFixed(2);

        $(this).closest('div').find('.total').text(formattedSubtotal);
        total += subtotal;
    });

    // Format total with 2 decimal places
    var formattedTotal = total.toFixed(2);

    $('#total_amount .h2').text(formattedTotal);
    $('#total_amount_hidden').val(formattedTotal);
}

    </script>

@endsection
