@extends('layouts.app')

@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Supplier
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
                                <h5>Edit Supplier</h5>
                            </div>
                            
                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('update_supplier',$supplier->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $supplier->name }}" name="name" >
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Father Name</label>
                                        <input type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ $supplier->fname }}">
                                        @error('fname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $supplier->phone }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $supplier->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>NIC</label>
                                        <input type="text" class="form-control @error('nic') is-invalid @enderror" name="nic" value="{{ $supplier->nic }}">
                                        @error('nic')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="4">{{ $supplier->address }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Update supplier</button>
                                        <a href="{{route('show_supplier')}}" class="btn btn-pill btn-gradient color-4">Back</a>
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
