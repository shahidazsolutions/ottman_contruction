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

    .card img{
        width:200px;
        height:200px;
        border-radius:50%;
        border:1px solid black;
    }
    .contractor-details p {
        margin-bottom: 10px;
    }

    .contractor-details strong {
        color: #333;
    }
</style>

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
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-lg-12">
                <div class="card w-50 m-auto border">
                    <div class="card-header pb-0">
                        <h3>Supplier Detail</h3>
                    </div>
                    @foreach($supplier as $supplier)
                    <div class="card-body">
                        <div class="text-center">

                        <img src="{{ asset('images/supplier/'.$supplier->image) }}" alt="Supplier Image" class="m-auto border">
                        </div>
                        <div class="supplier-details mt-4">
                            <p class="h4"><strong >Name :</strong> {{ $supplier->name }}</p>
                            <p class="h4"><strong>Email :</strong> {{ $supplier->email }}</p>
                            <p class="h4"><strong>Nic :</strong> {{ $supplier->nic }}</p>
                            <p class="h4"><strong>Phone :</strong> {{ $supplier->phone }}</p>
                            <p class="h4"><strong>Address:</strong> {{ $supplier->address }}</p>
                            <!-- Add more details as needed -->
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid end -->
</div>

@endsection
