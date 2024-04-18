@extends('layouts.app')
@section('title','Contractors')
@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Contractor
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
                                <h5>Edit Contractor</h5>
                            </div>

                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('contractor.update',$contractor->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter contractor name" class="form-control @error('name') is-invalid @enderror" value="{{ $contractor->name }}" name="name" >
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <!--<div class="form-group col-sm-4">-->
                                    <!--    <label>Father Name <span class="text-danger">*</span></label>-->
                                    <!--    <input type="text" placeholder="Enter contractor father name" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ $contractor->fname }}">-->
                                    <!--    @error('fname')-->
                                    <!--        <span class="text-danger">{{ $message }}</span>-->
                                    <!--    @endif-->
                                    <!--</div>-->
                                    <div class="form-group col-sm-4">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Enter contractor phone number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $contractor->phone }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Email (Optional)</label>
                                        <input type="email" placeholder="Enter contractor email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $contractor->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>CNIC <span class="text-danger">*</span></label>
                                        <input type="number" placeholder="Enter contractor cnic" class="form-control @error('nic') is-invalid @enderror" name="nic" value="{{ $contractor->nic }}">
                                        @error('nic')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Image (Optional)</label>
                                        <input type="file"  class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Address <span class="text-danger">*</span> </label>
                                        <textarea placeholder="Enter contractor address" class="form-control @error('address') is-invalid @enderror" name="address" rows="4">{{ $contractor->address }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Update Contractor</button>
                                        <a href="{{route('contractor.all-contractors')}}" class="btn btn-pill btn-gradient color-4">Back</a>
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
