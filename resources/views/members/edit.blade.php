@extends('layouts.app')
@section('title','Members')
@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Update Members
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
                                <h5>Update Members</h5>
                            </div>

                            <div class="card-body admin-form">
                                @foreach ($members as $member)

                                <form class="row gx-3" method="POST" action="{{route('admin.members.update',$member->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group col-sm-4">
                                        <label>Name <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="Enter name" class="form-control @error('name') is-invalid @enderror" value="{{ $member->name }}" name="name" >
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>Phone <span class="text-danger">*</span> </label>
                                        <input type="number" placeholder="Enter phone number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $member->number }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-sm-4">
                                        <label>CNIC <span class="text-danger">*</span> </label>
                                        <input type="number" placeholder="Enter cnic" class="form-control @error('nic') is-invalid @enderror" name="nic" value="{{ $member->nic }}">
                                        @error('nic')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label>Address <span class="text-danger">*</span> </label>
                                        <textarea  placeholder="Enter address" class="form-control @error('address') is-invalid @enderror" name="address" rows="4">{{ $member->address }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Update Member</button>
                                        <a href="{{route('admin.members.index')}}" class="btn btn-pill btn-gradient color-4">Back To Members</a>
                                    </div>
                                </form>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->

        </div>

@endsection
