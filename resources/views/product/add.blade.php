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
                                <h5>Add Products</h5>
                            </div>
                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('product.insert') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label for="" class="form-label">Project <span class="text-danger">*</span> </label>
                                        <select class="form-select" name="project_id" id="">
                                            <option selected value="">Select Project</option>
                                            @foreach ($project as $item)
                                                <option value="{{$item->id}}" @selected(old('project_id') == $item->id)>{{$item->project_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                            <span class="text-danger">The project name field is required.</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="" class="form-label">Block <span class="text-danger">*</span></label>
                                        <select class="form-select" name="room_number" id="">
                                            <option selected value="">Select Blook</option>
                                            @foreach(range('A','Z') as $v)
                                                <option value="{{$v}}" @selected(old('room_number') == $v)>{{$v}}</option>
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
                                                <option value="{{$v}}" @selected(old('floor_number') == $v)> {{$v}}</option>
                                            @endforeach
                                        </select>
                                        @error('floor_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Flat Size <span class="text-danger">*</span>  </label>
                                        <input type="number" step="any" placeholder="flat size" class="form-control @error('flate_size') is-invalid @enderror"  value="{{ old('flate_size') }}" name="flate_size" id="flate_size">
                                        @error('flate_size')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="form-group col-sm-4">
                                        <label>Unite Price <span class="text-danger">*</span> </label>
                                        <input type="number" step="any" placeholder="Enter unit price" class="form-control @error('unit_price') is-invalid @enderror" name="unit_price" id="unit_price" value="{{ old('unit_price') }}">
                                        @error('unit_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div> --}}

                                    {{-- <div class="form-group col-sm-4 " id="total_flate">
                                        <label>Total Flat Price <span class="text-danger">*</span> </label>
                                        <input type="text" step="any" name="flat_price" id="flat_price" placeholder="0" class="form-control @error('flat_price') is-invalid @enderror" >
                                        @error('flat_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                    </div> --}}

                                    {{-- <div class="form-group col-sm-4">
                                        <label>Car Parking Charges (Optional)</label>
                                        <input type="number" step="any" placeholder="Car Parking Charges (optional)" class="form-control price" name="parking_charge" value="{{ old('parking_charge') }}" id="car_charge">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Utility Charge (Optional)</label>
                                        <input type="number" step="any" placeholder="Unility charges (optional)"  class="form-control price" name="utility_charge" value="{{ old('utility_charge') }}" id="utility_charge">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Additional Charges (Optional) </label>
                                        <input type="number" step="any" placeholder="Additional charges (optional)" class="form-control price" name="additional_charge" value="{{ old('additional_charge') }}" id="additional_charge">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Other Charge (Optional)</label>
                                        <input type="number" step="any" placeholder="Other (optional)" class="form-control price" name="other_charge" value="{{ old('other_charge') }}" id="other_charge">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Discount (Optional)</label>
                                        <input type="number" step="any" placeholder="Discount (optional)" class="form-control price" name="discount_deduction" value="{{ old('discount_deduction') }}" id="discount_deduction">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Refund Additional Work Charge (Optional)</label>
                                        <input type="number" step="any" placeholder="Refund additional charges (optional)" class="form-control price" name="refund_charge" value="{{ old('refund_charge') }}" id="refund_charge">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Net Sells Price </label>
                                        <h2 id="netSellPrice">0</h2>
                                        <input type="hidden" step="any" id="net_total" name="flat_net_price">
                                    </div> --}}
                                    <div class="form-group col-sm-8">
                                        <label>File  (Optional) </label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" value="{{ old('file') }}">
                                        @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Description (Optional)</label>
                                        <textarea class="form-control" placeholder="description (optional)" name="description" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4 px-4">Add Product</button>
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
                $("#unit_price").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var total = parseFloat(unit_price*(flate_size)).toFixed(2);
                    $("#flat_price").val(total);
                    var total_flate = $("#flat_price").val() || 0;
                    $("#netSellPrice").text(total_flate);
                    $("#net_total").val(total_flate);
                    // $("#flate_price").val(total);
                });
                $("#flate_size").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var total = parseFloat(unit_price*(flate_size*flate_size)).toFixed(3);
                    $("#flat_price").val(total) ;
                    var total_flate = $("#flat_price").val() || 0;
                    $("#netSellPrice").text(parseFloat(total_flate).toFixed(3));
                    $("#net_total").val(parseFloat(total_flate).toFixed(3));
                    // $("#flate_price").val(total);
                });
                $("#flat_price").keyup(function(){
                    let totalAmnt = $(this).val();
                    var flate_size = $("#flate_size").val() || 0;
                    var unit_price = $("#unit_price").val(parseFloat(totalAmnt/(flate_size)).toFixed(3));
                    setTimeout(() => {

                    }, 200);
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
                    $("#net_total").val(parseFloat(data3).toFixed(3));
                });
                $("#utility_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var utility_charge = $("#utility_charge").val() || 0;
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
                    $("#net_total").val(parseFloat(data3).toFixed(3));
                });
                $("#additional_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var additional_charge = $("#additional_charge").val() || 0;
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
                    $("#net_total").val(parseFloat(data3).toFixed(3));
                });
                $("#other_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var other_charge = $("#other_charge").val() || 0;
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
                });
                $("#discount_deduction").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var discount_deduction = $("#discount_deduction").val() || 0;
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

                        $("#net_total").val(parseFloat(data3).toFixed(3));
                    $("#netSellPrice").text(data3);
                });
                $("#refund_charge").keyup(function(){
                    var unit_price = $("#unit_price").val() || 0;
                    var flate_size = $("#flate_size").val() || 0;
                    var refund_charge = $("#refund_charge").val() || 0;
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

                        $("#net_total").val(parseFloat(data3).toFixed(3));
                    $("#netSellPrice").text(data3);
                });
            });
        </script>
@endsection
