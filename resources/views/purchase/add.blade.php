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
                        <h5>Confirm Purchase </h5>
                    </div>

                    <div class="card-body admin-form">
                        @foreach ($purchases as $purchase)
                        <form action="{{ route('purchase-requistion.confirm',$purchase->id) }}" method="post">
                            @csrf


                            <div class="container-fluid border my-3 py-3">
                                <div class="row">
                              

                                    <div class="form-group col-sm-4">
                                        <label>Project </label>
                                        <select class="form-select" name="project_id" id="" disabled>
                                            <option selected value="">Select Project</option>
                                            @foreach ($project as $item)
                                            <option {{ ($item->id==$purchase->project_id)?"selected":"" }}
                                                value="{{$item->id}}" @selected(old('project_id')==$item->
                                                id)>{{$item->project_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id')
                                        <span class="text-danger">The project name field is required.</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Supplier</label>
                                        <select class="form-select" name="supplier_id" id="">
                                            <option selected value="">Select Supplier</option>
                                            @foreach ($suppliers as $men)
                                            <option value="{{$men->id}}" {{ ($purchase->
                                                supplier_id==$men->id)?"selected":"" }}
                                                @selected(old('supplier_id')==$men->
                                                id)>{{$men->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                        <span class="text-danger">The project name field is required.</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Requistion Date</label>
                                        <input type="date"
                                            class="form-control @error('requistion_date') is-invalid @enderror"
                                            name="requistion_date" value="{{ $purchase->requistion_date }}" disabled>
                                        @error('requistion_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Required Date</label>
                                        <input type="date"
                                            class="form-control @error('required_date') is-invalid @enderror"
                                            name="required_date" value="{{ $purchase->required_date }}" disabled>
                                        @error('required_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Remarks</label>
                                        <input type="text" class="form-control @error('remark') is-invalid @enderror"
                                            name="remark" value="{{ $purchase->remark }}">
                                        @error('remark')
                                        <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>



                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header pb-0">
                                            <h5>Requistion Items</h5>
                                        </div>
                                        <div class="card-body admin-form" id="item">
                                            @foreach ($purchase->getPurchaseItems as $key=> $purchaseItems)

                                            <div class="row item-row">
                                                <div class="col-sm-2">
                                                    <label>Item </label>
                                                    <select class="form-select" name="item_id[]" id="" value="">
                                                        <option selected="" value="" disabled="">Select Items</option>
                                                        @foreach ($items as $item)
                                                        <option {{ ($item->id==$purchaseItems->item_id)?"selected":"" }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class=" col-sm-2">
                                                    <label>Unit </label>
                                                    <select class="form-select" name="unit_id[]" id="" value="">
                                                        <option selected="" value="" disabled="">Select Unit</option>
                                                        @foreach ($units as $unit)
                                                        <option {{ ($unit->id==$purchaseItems->unit_id)?"selected":"" }}
                                                            value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class=" col-sm-2">
                                                    <label>Quantity </label>
                                                    <input type="number" class="form-control quantity   " id="quantity0"
                                                        name="quantity[]" value="{{ $purchaseItems->quantity }}"
                                                        onkeyup="multiply()">
                                                </div>
                                                <div class=" col-sm-2">
                                                    <label>Rate </label>
                                                    <input type="number" class="form-control rate  "
                                                        value="{{ $purchaseItems->rate }}" id="rate0" name="rate[]"
                                                        onkeyup="multiply()">
                                                </div>
                                                <div class=" col-sm-2">
                                                    <label>Total </label>
                                                    <h2 id="total0" class="total">{{ $purchaseItems->quantity *
                                                        $purchaseItems->rate }}</h2>
                                                </div>

                                                @if ($key>0)
                                                <div class=" col-sm-2"
                                                    style="display: inline-flex; align-items: center;">
                                                    <button type="button"
                                                        class="btn btn-danger delete_item_input">-</button>
                                                </div>
                                                @else

                                                <div class="col-sm-2"
                                                    style="display: inline-flex; align-items: center;">
                                                    <button type="button"
                                                        class="btn btn-primary add_item_input">+</button>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>

                                        <div class=" col-sm-12">
                                            <h3 id="total_amount">Total Amount <span class="h2">{{ $purchase->amount }}
                                                </span></h3>
                                            <input type="hidden" id="total_amount_hidden"
                                                value="{{ $purchase->amount }}" name="amount">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-btn col-sm-12">
                                <button id="success" type="sumbit"
                                    class="btn btn-pill btn-gradient color-4">Create</button>
                            </div>
                        </form>

                        @endforeach
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid end -->
</div>



<script>
    $(document).ready(function(){
        var numid=1;
        $(".add_item_input").click(function(){
          var datanum =  numid++;
            var data = `<div class="row item-row" >
            <div class="col-sm-2">

                <label>Item </label>
                <select class="form-select" name="item_id[]" id="${datanum}" value="">
                    <option selected value="">Select </option>
                    @foreach ($items as $item)
                        <option value="{{$item->id}}" >{{$item->name}}</option>
                    @endforeach
                </select>
                @error('item_id.${datanum}')
                    <span class="text-danger">The Item field is required.</span>
                @endif
            </div>
            <div class=" col-sm-2">
                <label>Unit </label>
                <select class="form-select" name="unit_id[]" id="" value="">
                    <option selected value="">Select </option>
                    @foreach ($units as $item)
                        <option value="{{$item->id}}" >{{$item->name}}</option>
                    @endforeach
                </select>
                @error('unit_id.${datanum}')
                    <span class="text-danger">The unit  field is required.</span>
                @endif
            </div>
            <div class=" col-sm-2">
                <label>Quantity </label>
                <input type="number" class="form-control quantity" value="" name="quantity[]" onkeyup="multiply()" id="quantity${datanum}">
                @error('quantity.${datanum}')
                    <span class="text-danger">{{ $message }}</span>
                @endif
            </div>
            <div class=" col-sm-2">
                <label>Rate </label>
                <input type="number" class="form-control rate @error('rate') is-invalid @enderror rate" value="" name="rate[]" id="rate${datanum}" onkeyup="multiply()">
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

    });



    function multiply (){
        total = 0;
        $('.item-row').each(function(){
       qty =  $(this).closest('div').find('.quantity').val()|| 0;
       rate =  $(this).closest('div').find('.rate').val() || 0;
            $(this).closest('div').find('.total').text(qty*rate);
            total += (qty*rate);

    });
    $('#total_amount .h2').text(total);
    $('#total_amount_hidden').val(total);

    }
</script>

@endsection
