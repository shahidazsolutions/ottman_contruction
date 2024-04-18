@extends('layouts.app')

@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Customer
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
                                <h5>Edit Customer</h5>
                            </div>

                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('customer.update',$customer->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-6">
                                        <label>Name <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="customer name" class="form-control @error('name') is-invalid @enderror" value="{{ $customer->name }}" name="name" >
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>S/o, W/o <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="customer father name" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ $customer->fname }}">
                                        @error('fname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Mobile Number <span class="text-danger">*</span> </label>
                                        <input type="number" placeholder="customer mobile number" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number" value="{{ $customer->mobile_number }}">
                                        @error('mobile_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Office Phone Number (optional)</label>
                                        <input type="number" placeholder="customer office number" class="form-control @error('office_number') is-invalid @enderror" name="office_number" value="{{ $customer->office_number }}">
                                        @error('office_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Residient Number (optional)</label>
                                        <input type="number" placeholder="resident number" class="form-control @error('res_number') is-invalid @enderror" name="res_number" value="{{ $customer->res_number }}">
                                        @error('res_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Email (optional)</label>
                                        <input type="email" placeholder="customer email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $customer->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>CNIC <span class="text-danger">*</span> </label>
                                        <input type="number" placeholder="customer cnic" class="form-control @error('nic') is-invalid @enderror" name="nic" value="{{ $customer->nic }}">
                                        @error('nic')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Image (optional)</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Address  (optional)</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="4">{{ $customer->address }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Update Customer</button>
                                        <a href="{{route('customer.all-customers')}}" class="btn btn-pill btn-gradient color-4">Back</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->

        </div>

@endsection
