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

    .card img {
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

            @foreach($contractor as $contractor)
            <div class="col-2">
                <div class="">
                    @if ($contractor->image)
                    <img src="{{ asset('images/contractor/'.$contractor->image) }}" alt="Contractor Image"
                    class="m-auto border rounded-circle">

                        @else
                    <img src="{{ asset('images/user.jpeg') }}" alt="Contractor Image"
                    class="m-auto border rounded-circle">

                    @endif
                </div>
            </div>
            <div class="col-6">

                <div class="card-body">
                    <ul class="mx-2">

                        <li class="list-group-item h4"><strong>Name :</strong> {{ $contractor->name }}</li>
                        <li class="list-group-item h4"><strong>Email :</strong> {{ $contractor->email }}</li>
                        <li class="list-group-item h4"><strong>Nic :</strong> {{ $contractor->nic }}</li>
                        <li class="list-group-item h4"><strong>Phone :</strong> {{ $contractor->phone }}</li>
                        <li class="list-group-item h4"><strong>Address:</strong> {{ $contractor->address }}</li>
                        <!-- Add more details as needed -->
                    </ul>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <!-- Container-fluid end -->
</div>

@endsection
