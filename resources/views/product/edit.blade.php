@extends('layouts.app')

@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Products
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
                                <h5>Update Products</h5>
                            </div>
                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('update_product',$product->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label for="" class="form-label">Project <span class="text-danger">*</span> </label>
                                        <select class="form-select" name="project_id" id="">
                                            <option selected value="">Select Project</option>
                                            @foreach ($project as $item)
                                                <option value="{{$item->id}}" {{ $item->id == $product->project_id ? 'selected' : '' }} >{{$item->project_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="" class="form-label">Block <span class="text-danger">*</spans> </label>
                                        <select class="form-select" name="room_number" id="">
                                            <option selected value="">Select Blook</option>
                                            @foreach(range('A','Z') as $v)
                                                <option value="{{$v}}" {{$v}}" {{ $v == $product->room_number ? 'selected' : '' }}>{{$v}}</option>
                                            @endforeach
                                        </select>
                                        @error('room_number')
                                            <span class="text-danger">The blook number field is required.</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="" class="form-label">Floor <span class="text-danger">*</span> </label>
                                        <select class="form-select" name="floor_number" id="">
                                            <option selected value="">Select Floor</option>
                                            @foreach(range('1','20') as $v)
                                                <option value="{{$v}}" {{ $v == $product->floor_number ? 'selected' : '' }}> {{$v}}</option>
                                            @endforeach
                                        </select>
                                        @error('floor_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Flat Size <span class="text-danger">*</span> </label>
                                        <input type="number" step="any" placeholder="flat size" class="form-control @error('flate_size') is-invalid @enderror"  value="{{ $product->flate_size }}" name="flate_size" id="flate_size">
                                        @error('flate_size')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Unite Price <span class="text-danger">*</span> </label>
                                        <input type="number" step="any" placeholder="flat price" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="unit_price" value="{{ $product->unit_price }}">
                                        @error('unit_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4 " id="total_flate">
                                        <label>Flat Price <span class="text-danger">*</span> </label>
                                        <input type="number" step="any" placeholder="flat price" id="flat_price" placeholder="0" name="flat_price" class="form-control @error('flat_price') is-invalid @enderror" >
                                        {{-- total_flate_price --}}
                                        {{-- <h2 id="flate_price">0</h2> --}}
                                        @error('flat_price')
                                                <span class="text-danger">*</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group col-sm-4 " id="total_flate">
                                        <label>Total Flat Price</label>
                                        <h2 id="flate_price">0</h2>

                                    </div> --}}
                                    <div class="form-group col-sm-4">
                                        <label>Car Parking Charges (Optional)</label>
                                        <input type="number" step="any" placeholder="car parking charges" class="form-control @error('parking_charge') is-invalid @enderror price" name="parking_charge" value="{{ $product->parking_charge }}" id="car_charge">
                                        @error('parking_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Utility Charges (Optional)</label>
                                        <input type="number" step="any" placeholder="utility charges" class="form-control @error('utility_charge') is-invalid @enderror price" name="utility_charge" value="{{ $product->utility_charge }}" id="utility_charge">
                                        @error('utility_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Additional Work Charges (Optional)</label>
                                        <input type="number" step="any" placeholder="Additinal work charges" class="form-control @error('additional_charge') is-invalid @enderror price" name="additional_charge" value="{{ $product->additional_charge }}" id="additional_charge">
                                        @error('additional_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Other Charges (Optional)</label>
                                        <input type="number" step="any" placeholder="other charges" class="form-control @error('other_charge') is-invalid @enderror price" name="other_charge" value="{{ $product->other_charge }}" id="other_charge">
                                        @error('other_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Discount (Optional)</label>
                                        <input type="number" step="any" placeholder="discount" class="form-control @error('discount_deduction') is-invalid @enderror price" name="discount_deduction" value="{{ $product->discount_deduction }}" id="discount_deduction">
                                        @error('discount_deduction')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Refund Charges (Optional)</label>
                                        <input type="number" step="any" class="form-control @error('refund_charge') is-invalid @enderror price" name="refund_charge" value="{{ $product->refund_charge }}" id="refund_charge">
                                        @error('refund_charge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Net Sells Price </label>
                                        <h2 id="netSellPrice">0</h2>
                                        <input type="hidden" step="any" id="net_total" name="flat_net_price">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>File  (Optional)</label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}">
                                        @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Description (Optional)</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ $product->description }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Update Product</button>
                                        <a  href="{{ route('products.all-product') }}" class="btn btn-pill btn-gradient color-4 px-5">Back to Products</a>
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
                //On load
                var unit_price = $("#unit_price").val() || 0;
                var flate_size = $("#flate_size").val() || 0;
                var total = parseFloat(unit_price*(flate_size));
                $("#flat_price").val(total.toFixed(2));
                var total_flate = $("#flat_price").val(total) ;
                var sumdata = 0;
                        $('.price').each(function() {
                            if($(this).val()!="")
                            {
                                sumdata += parseFloat($(this).val());
                            }
                        });
                var  data3= total+sumdata;

                $("#netSellPrice").text(parseFloat(data3).toFixed(2));
                $("#net_total").val(data3);

                // $("#netSellPrice").text(total_flate);

                $("#unit_price").keyup(function(){
                    // if(Number.isFloat(parseFloat($(this).val())) == false){$(this).val(0)}
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var total = parseFloat(unit_price*(flate_size)).toFixed(2);
                    $("#flat_price").val(total);
                    var total_flate = $("#flat_price").val() || 0;
                    $("#flat_price").text(total_flate);

                    // $("#flate_price").val(total);
                });
                $("#flate_size").keyup(function(){
                    // if(Number.isFloat(parseFloat($(this).val())) == false){$(this).val(0)}

                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var total = parseFloat(unit_price*flate_size).toFixed(3);
                    $("#flat_price").val(total);
                    var total_flate = $("#flat_price").val();
                    $("#netSellPrice").text(parseFloat(total_flate).toFixed(3));
                    $("#net_total").val(total_flate);
                    // $("#flate_price").val(total);
                });
                $("#flat_price").keyup(function(){
                    // if(Number.isFloat(parseFloat($(this).val())) == false){$(this).val(0)}
                    let totalAmnt = $(this).val();
                    var flate_size = $("#flate_size").val() || 0;
                    var unit_price = $("#unit_price").val(parseFloat(totalAmnt/(flate_size)).toFixed(3));
                    $("#netSellPrice").text(totalAmnt);
                    $("#net_total").val(total_flate);
                    // setTimeout(() => {
                    //     console.log(
                    //         "Total Amount: ", totalAmnt,
                    //         "Flat Price: ", flate_size,
                    //         "Unit Price: ", parseFloat(totalAmnt/flate_size).toFixed(1),
                    //         // "Flat Price: ", totalAmnt/(totalAmnt/(totalAmnt/2)),
                    //         // "Unit Price: ",totalAmnt/(totalAmnt/2)
                    //         )
                    // }, 200);
                });


                $("#car_charge").keyup(function() {

                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var car_charge = $("#car_charge").val() || 0;
                    var total = unit_price*(flate_size);

                        var sumdata = 0;
                        $('.price').each(function() {

                            if($(this).val()!=""){

if($(this).attr('name')=='discount_deduction'){
    sumdata -= parseFloat($(this).val());

}else{


sumdata += parseFloat($(this).val());
}
}

                        });
                        var  data3= total+sumdata;

                     $("#netSellPrice").text(data3);
                    $("#net_total").val(data3);
                });


                $("#utility_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var utility_charge = $("#utility_charge").val();
                    var total = unit_price*(flate_size);

                        var sumdata = 0;
                        $('.price').each(function() {

                            if($(this).val()!=""){

if($(this).attr('name')=='discount_deduction'){
    sumdata -= parseFloat($(this).val());

}else{


sumdata += parseFloat($(this).val());
}
}

                        });
                        var  data3= total+sumdata;

                     $("#netSellPrice").text(data3);
                    $("#net_total").val(data3);
                });


                $("#additional_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var additional_charge = $("#additional_charge").val() || 0;
                    var total = unit_price*flate_size;

                        var sumdata = 0;
                        $('.price').each(function() {
                            if($(this).val()!=""){

if($(this).attr('name')=='discount_deduction'){
    sumdata -= parseFloat($(this).val());

}else{


sumdata += parseFloat($(this).val());
}
}

                        });
                        var  data3= total+sumdata;

                     $("#netSellPrice").text(data3);
                    $("#net_total").val(data3);
                });

                $("#other_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var other_charge = $("#other_charge").val() || 0;
                    var total = unit_price*flate_size;

                        var sumdata = 0;
                        $('.price').each(function() {
                            if($(this).val()!=""){

if($(this).attr('name')=='discount_deduction'){
    sumdata -= parseFloat($(this).val());

}else{


sumdata += parseFloat($(this).val());
}
}

                        });
                        var  data3= total+sumdata;

                     $("#netSellPrice").text(data3);
                    $("#net_total").val(data3);
                });


                $("#discount_deduction").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var discount_deduction = $("#discount_deduction").val() || 0;
                    var total = unit_price*(flate_size);


                        var sumdata = 0;
                        $('.price').each(function() {

                            if($(this).val()!="")
                            {
                                if($(this).val()!=""){

if($(this).attr('name')=='discount_deduction'){
    sumdata -= parseFloat($(this).val());

}else{


sumdata += parseFloat($(this).val());
}
}


                            }
                        });
                        var  data3= total+sumdata;

                     $("#netSellPrice").text(data3);
                    $("#net_total").val(data3);


                });
                $("#refund_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var refund_charge = $("#refund_charge").val() || 0;
                    var total = unit_price*flate_size;


                        var sumdata = 0;
                        $('.price').each(function() {
                            if($(this).val()!=""){

if($(this).attr('name')=='discount_deduction'){
    sumdata -= parseFloat($(this).val());

}else{


sumdata += parseFloat($(this).val());
}
}

                        });
                        var  data3= total+sumdata;

                     $("#netSellPrice").text(data3);
                    $("#net_total").val(data3);



                });
            });
        </script>
@endsection
