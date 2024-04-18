@extends('layouts.app')

@section('content')
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>All Supplier
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
                <div class="row agent-section property-section agent-lists">
                    <div class="col-lg-12">
                        <div class="ratio2_3">
                            <div class="property-2 row column-sm property-label property-grid">
                            @foreach ($supplier as $data)
                                    
                                <div class="col-xl-4 col-md-6 wow fadeInUp">
                                    <div class="property-box">
                                        <div class="agent-image">
                                            <div>
                                                <img  src="{{asset('/images/supplier/'.$data->image)}}" class="bg-img" alt="">
                                            </div>
                                        </div>
                                        <div class="agent-content">
                                            <h3><a href="agent-profile.html">{{$data->name}}</a></h3>
                                            <p class="font-roboto">Father Name : {{$data->fname}}</p>
                                            <ul class="agent-contact">
                                                <li>
                                                    <i class="fas fa-phone-alt"></i> 
                                                    <span class="">{{$data->phone}}</span>
                                                </li>
                                                <li><i class="fas fa-envelope"></i> {{$data->email}}</li>
                                                <li><i class="fas fa-fax"></i> {{$data->nic}}</li>
                                            </ul>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button class="btn btn-dashed btn-pill color-6" onclick="window.location='{{route('edit_supplier',$data->id)}}'"><i class="fa-solid fa-pen-to-square"></i>  </button>
                                                    
                                                    <button type="button"  class="btn btn-dashed btn-pill color-4">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="agent-profile.html">View profile <i class="fas fa-arrow-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach   
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->
        </div>
        
@endsection