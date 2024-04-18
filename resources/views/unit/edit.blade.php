@extends('layouts.app')

@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Unit
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
                                <h5>Edit Unit</h5>
                            </div>
                            
                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('unit.update',$unit->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label>Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $unit->name }}" name="name" >
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Update Unit</button>
                                        <a href="{{route('unit.all')}}" class="btn btn-pill btn-gradient color-4">Back</a>
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
