@extends('layouts.app')

@section('content')

<style>
    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .flat-details {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .flat-details img {
        width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .flat-info {
        flex: 1;
        margin-left: 20px;
    }

    .flat-info p {
        margin: 5px 0;
    }

    img {
        height: 300px;
        width: 50% !important;
    }
</style>

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
    <div class="container">
        <h1>Flat Details</h1>
        @foreach($product as $flat)
        <div>
            @if ($flat->image)
            <img src="{{ asset('images/file/'.$flat->file) }}" class="rounded-3 w-100" alt="Flat Image">
            @endif


            <div class="container">
                <div class="row">
                    <div class="col-md-6">

                        <ul class="list-group">

                            <li class="list-group-item"><strong class="h4">Product Number: {{ $flat->room_number.$flat->floor_number }} </strong>
                            </li>
                            <li class="list-group-item"><strong class="h4">Floor Number: {{ $flat->floor_number }}</strong> </li>
                            <li class="list-group-item"><strong class="h4">Size: {{ $flat->flate_size }}Sq</strong> </li>
                            <li class="list-group-item"><strong class="h4">Flat Price: {{ formatAmount($flat->flat_price) }}</strong></li>
                            <li class="list-group-item">
                                <strong class="h4">Status :
                                    @if($flat->booking == 1)

                                    Booked
                                    @else
                                    Avaiable
                                    @endif

                                </strong>
                            </li>
                        </ul>

                    </div>
                    <div class="col-md-6">

                        <ul class="list-group">

                            <li class="list-group-item"><strong class="h4">Car Parking Charges : {{ $flat->parking_charge ?? 0 }} </strong> </li>
                            <li class="list-group-item"><strong class="h4">Utility Charges : {{ $flat->utility_charge ?? 0 }}</strong> </li>
                            <li class="list-group-item"><strong class="h4">Additional Charges : {{ $flat->additional_charge ?? 0 }}</strong> </li>
                            <li class="list-group-item"><strong class="h4">Orther Charges : {{ $flat->other_charge ?? 0 }}</strong> </li>
                            <li class="list-group-item"><strong class="h4">Discount : {{ $flat->discount_deduction ?? 0 }}</strong></li>
                            <li class="list-group-item">
                                <strong class="h4"> Net Total : {{ formatAmount($flat->flat_net_price) ?? 0 }}</strong>

                            </li>
                    </ul>
                        <!-- Add more details as needed -->

                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
