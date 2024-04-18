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
                            @isset($item_count)
                            @else
                            <form class="row gx-3" method="GET" action="{{route('purchase.add')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-4">
                                    <label>Requistion ID </label>
                                    <select class="form-select" name="requistion_id[]"  id="" value="old('requistion_id.0')">
                                        <option selected value="" disabled>Select Id</option>
                                        @foreach ($reqs as $data)
                                            <option value="{{$data->r_id}}"  @selected(old('requistion_id.0') == $data->id) >{{$data->r_id}}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="text-danger">The Supplier name field is required.</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <input type="submit" class="btn btn-pill btn-gradient color-4 mt-4" value="Submit">
                                </div>
                            </form>
                            @endisset

                            @isset($not_id)
                            <div class="row gx-3">
                                <div class="form-group col-sm-4">
                                    <label>Project </label>
                                    <select class="form-select" name="project_id" id="" disabled>
                                        <option selected value="">Select Project</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Contractor</label>
                                    <select class="form-select" name="contractor_id" id="" disabled>
                                        <option selected value="">Select Contractor</option>
                                        
                                    </select>
                                    @error('contractor_id')
                                        <span class="text-danger">The project name field is required.</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Requistion Date</label>
                                    <input type="date" class="form-control " disabled>
                                    @error('requistion_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Required Date</label>
                                    <input type="date" class="form-control" disabled>
                                    @error('required_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Remark <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" disabled>
                                    @error('remark')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Image</label>
                                    <input type="file" class="form-control" disabled>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="card"> 
                                    <div class="card-header pb-0">
                                        <h5>Requistion Items</h5>
                                    </div>
                                    <div class="card-body admin-form" id="item">
                                        <div class="row" >
                                            <div class="col-sm-2">
                                                <label>Item </label>
                                                <select class="form-select" name="item_id[]" id="" disabled>
                                                    <option selected value="">Select </option>
                                                    
                                                </select>
                                                @error('item_id')
                                                    <span class="text-danger">The Item field is required.</span>
                                                @endif
                                            </div>   
                                            <div class=" col-sm-2">
                                                <label>Unit </label>
                                                <select class="form-select" name="unit_id[]" id="" disabled>
                                                    <option selected value="">Select </option>
                                                    
                                                </select>
                                                @error('unit_id')
                                                    <span class="text-danger">The unit  field is required.</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Quantity </label>
                                                <input type="number" class="form-control" disabled>
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Rate </label>
                                                <input type="number" class="form-control " disabled>
                                                @error('rate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Total </label>

                                                <h2 id="total0" class="total">0</h2>
                                            </div>
                                            <div class=" col-sm-2">
                                                <button type="button" class="btn btn-primary add_item_input">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-sm-12">
                                        <h3 id="total_amount" >Total Amount <span class="h2" >0 </span></h3>
                                        <input type="hidden" id="total_amount_hidden" value="" name="total_amount">
                                    </div>
                                </div> 
                                <div class="form-btn col-sm-12">
                                    <button id="success" type="button"  class="btn btn-pill btn-gradient color-4">Create</button>
                                </div>
                            </div>
                            @endisset
                            @isset($purchase_requistion)
                            <form class="row gx-3" method="POST" action="{{route('purchase.insert')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group col-sm-4">
                                    <label>Supplier </label>
                                    <select class="form-select" name="supplier_id[]"  id="">
                                        <option selected value="" disabled>Select Supplier</option>
                                        @foreach ($supplier as $data)
                                            <option value="{{$data->id}}"  @selected(old('supplier_id.0') == $data->id) >{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="text-danger">The Supplier name field is required.</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Project </label>
                                    <select class="form-select" name="project_id" disabled id="">
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
                                    <label>Contractor</label>
                                    <select class="form-select" name="contractor_id" id="" disabled>
                                        <option selected value="">Select Contractor</option>
                                        @foreach ($contractor as $men)
                                            <option value="{{$men->id}}" @selected($purchase_requistion->contractor_id == $men->id)>{{$men->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('contractor_id')
                                        <span class="text-danger">The project name field is required.</span>
                                    @endif
                                </div>
                                <input type="hidden" name="purchase_reuestion_id" value="{{$purchase_requistion->id}}">
                                <div class="form-group col-sm-4">
                                    <label>Requistion Date</label>
                                    <input type="date" disabled class="form-control @error('requistion_date') is-invalid @enderror" name="requistion_date" value="{{ $purchase_requistion->requistion_date}}">
                                    @error('requistion_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Required Date</label>
                                    <input type="date" disabled class="form-control @error('required_date') is-invalid @enderror" name="required_date" value="{{ $purchase_requistion->required_date }}">
                                    @error('required_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Remark</label>
                                    <input type="text" disabled class="form-control @error('remark') is-invalid @enderror" name="remark" value="{{ $purchase_requistion->remark }}">
                                    @error('remark')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4">
                                    <label>Image</label>
                                    <input type="file" disabled class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-8">
                                    <label>Purpose</label>
                                    <input type="text"  class="form-control @error('purpose') is-invalid @enderror" name="purpose" value="{{old('purpose')}}">
                                    @error('purpose')
                                        <span class="text-danger">{{ $message }}</span>
                                    @endif
                                </div>
                                <div class="card"> 
                                    <div class="card-header pb-0">
                                        <h5>Requistion Items</h5>
                                    </div>
                                    <div class="card-body admin-form" id="item">
                                        {{-- {{$purchase_requistion_item}} --}}
                                        @foreach($purchase_requistion_item as $key => $data)
                                        <div class="row row_{{$key}}" id="{{$key}}">
                                            <div class="col-sm-2">
                                                <label>Item </label>
                                                <select class="form-select" disabled name="item_id[]" id="">
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
                                            <div class=" col-sm-2">
                                                <label>Unit </label>
                                                <select class="form-select" disabled name="unit_id[]" id="">
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
                                                <input type="number" disabled class="form-control @error('quantity') is-invalid @enderror" id="quantity{{$key}}" value="{{ $data->quantity }}" name="quantity[]" onkeyup="multiply({{$key}})">
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Rate </label>
                                                <input type="number" disabled class="form-control @error('rate') is-invalid @enderror " value="{{ $data->rate }}" id="rate{{$key}}"  name="rate[]" onkeyup="multiply({{$key}})">
                                                @error('rate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @endif
                                            </div>
                                            <div class=" col-sm-2">
                                                <label>Total </label>
                                                <h2 id="total{{$key}}" class="total">{{old('total_amount')}}</h2>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class=" col-sm-12">
                                        <h3 id="total_amount" >Total Amount <span class="h2" >{{old('total_amount')}} </span></h3>
                                        <input type="hidden" id="total_amount_hidden" value="{{old('total_amount')}}" name="total_amount">
                                    </div>
                                </div>
                                <div class="form-btn col-sm-12">
                                    <button id="success" type="sumbit"  class="btn btn-pill btn-gradient color-4">Create</button>
                                </div> 
                            </form> 
                            @endisset
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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