@extends('layouts.app')

@section('content')
<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    /*.contractor-image {*/
    /*    max-width: 100%;*/
    /*    height: auto;*/
    /*    border-radius: 10px;*/
    /*    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);*/
    /*    margin-bottom: 20px;*/
    /*}*/

     img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 1px solid black;
    }

    /* .contractor-details p {
        margin-bottom: 10px;
    }

    .contractor-details strong {
        color: #333;
    } */
</style>

<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Admin Profile
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

            {{-- @foreach($contractor as $contractor) --}}
            <div class="offset-2 col-2">
                <div class="">
                    @if ($admin->profile)
                    <img src="{{ asset('images/admin/'.$admin->profile) }}" alt="Contractor Image"
                    class="m-auto border rounded-circle">

                        @else
                    <img src="{{ asset('images/user.jpeg') }}" alt="Contractor Image"
                    class="m-auto border rounded-circle">

                    @endif
                </div>
            </div>
            <div class="col-6">

                <div class="card-body">
                    <form action="{{ route('admin.profile.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="container">
                            <div class="row g-3">

                                <div class="col-md-12">
                                    <label for="">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $admin->name }}">
                            </div>
                            <div class="col-md-12">
                                <label for="">Email <span class="text-danger">*</span> </label>
                                <input type="email" name="email" class="form-control" value="{{ $admin->email }}">
                            </div>
                            <div class="col-md-12">
                                <label for="">Profile</label>
                                <input type="file" name="profile" class="form-control" value="">
                                @error('profile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-md-12">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" value="">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-md-12">
                                <label for="">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" value="">
                            </div>
                            <div class="col-12">
                                <input type="submit" class="btn btn-primary float-end">
                            </div>

                        </div>


                        </div>
                    </form>
                </div>
            </div>
            {{-- @endforeach --}}

        </div>
    </div>
    <!-- Container-fluid end -->
</div>

@endsection
