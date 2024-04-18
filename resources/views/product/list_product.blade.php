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
                            <div class="property-admin">
                                <div class="property-section section-sm">
                                    <div class="row ratio_55 property-grid-2 property-map map-with-back">
                                    {{-- @isset($product)
                                    @foreach ($product as $item)
                                        <div class="col-xl-4 col-md-6 xl-6 mt-4">
                                            <div class="property-box">
                                                <div class="property-image">
                                                    <div class="property-slider">
                                                        <a href="javascript:void(0)">
                                                            <img src="{{asset('/images/file/'.$item->file)}}" class="bg-img" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="property-details">
                                                    <div class="row">
                                                        <div class="col-sm-7">
                                                            <h6>RS : {{($item->unit_price * $item->flate_size)+ $item->parking_charge + $item->utility_charge + $item->additional_charge + $item->other_charge + $item->discount_deduction + $item->refund_charge}}
                                                            </h6>
                                                        </div>
                                                        <div class="col-sm-5 text-end">
                                                            <a class="btn btn-dashed btn-pill color-4" href="{{route('delete_product',$item->id)}}">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                            <a class="btn btn-dashed btn-pill color-6" href="{{route('edit_product',$item->id)}}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p class="font-roboto light-font">{{$item->description}}</p>
                                                    <ul>
                                                        <li><i class="fa-regular fa-building"></i> &nbsp Floor : {{$item->floor_number}}</li>
                                                        <li><i class="fa-solid fa-bed"></i> &nbsp Room : {{$item->room_number}}</li>
                                                        <li><img src="https://themes.pixelstrap.com/sheltos/assets/images/svg/icon/square-ruler-tool.svg" class="img-fluid ruler-tool" alt="">Sq Ft : {{$item->flate_size}}</li>
                                                    </ul>
                                                    <div class="property-btn d-flex">
                                                        <span>{{substr($item->created_at,0,10)}}</span>
                                                        <button type="button"  onclick="" class="btn btn-dashed btn-pill color-2">Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endisset --}}

                                        <div class="col ">
                                            <table class="table border table-striped table-border table-hovered" id="datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Sr</th>
                                                        <th>Project</th>
                                                        <th>Floor</th>
                                                        <th>Flat No</th>
                                                        <th>Flat Size</th>
                                                        <th>Unit Price</th>
                                                        <th>Flat Price</th>
                                                        <th>More</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($product as $key=> $product)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $product->project->project_name }}</td>
                                                        <td>{{ $product->floor_number }}</td>
                                                        <td>{{ $product->room_number }}</td>
                                                        <td>{{ $product->flate_size }}</td>
                                                        <td>{{ $product->unit_price }}</td>
                                                        <td>{{ $product->flat_net_price }}</td>
                                                        <td>
                                                            
                                                               <a class="btn btn-dashed btn-pill color-6" href="{{ route('show_products',$product->id) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                                </a>

                                                                <a class="btn btn-dashed btn-pill color-6" href="{{ route('edit_product',$product->id) }}">
                                                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>

                                                                </a>
                                                                <a class="btn btn-dashed btn-pill color-6" data-bs-toggle="modal" data-bs-target="#delete{{ $product->id }}" >

                                                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                                                </a>


                                                        </td>
                                                    </tr>



<!-- Modal -->
<div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{route('delete_product',$product->id)}}" method="POST">
            @csrf
            @method('DELETE')
            
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          Do you want to delete this?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </div>
    </form>
      </div>
    </div>
  </div>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                    </div>

                </div>
                <br>
    </div>
</div>

@endsection
