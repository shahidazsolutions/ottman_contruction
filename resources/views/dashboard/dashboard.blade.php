@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    .card:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease-in-out;
        cursor: pointer;
    }
</style>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Dashboard
                            <small>Welcome to admin panel</small>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-primary mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Projects</h5>
                        <hr>
                        <h2 class="card-text text-primary"><i class="fa-solid fa-building"></i><span class="h3 mx-4 float-end">{{ App\Models\Project::count()  }}</span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Customers</h5>
                        <hr>
                        <h2 class="card-text text-success"><i class="fa fa-user f-left"></i><span class="h3 mx-4 float-end">{{ App\Models\Customer::count()  }}</span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Suppliers</h5>
                        <hr>
                        <h2 class="card-text text-warning"><i class="fa fa-users f-left"></i><span class="h3 mx-4 float-end">{{ App\Models\Supplier::count()  }}</span></h2>
                    </div>
                </div>
            </div>
             <div class="col-md-3">
                <div class="card border-infor mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Contractors</h5>
                        <hr>
                        <h2 class="card-text text-infor"><i class="fa-solid fa-users-gear"></i><span class="h3 mx-4 float-end">{{ App\Models\Contractor::count()  }}</span></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-danger mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>

                        <hr>
                        <h2 class="card-text text-danger"><i class="fa-solid fa-house"></i><span class="h3 mx-4 float-end">{{ App\Models\Product::count()  }}</span></h2>
                    </div>
                </div>
            </div>

            {{-- <div class=" col-md-4 " colspan="2">
                <div class="card border-danger  mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Credit</h5>

                        <hr>
                        <h2 class="card-text text-success"><i class="fa-solid fa-wallet"></i><span class="h3 mx-4 float-end">{{ App\Models\Project::sum('amount') + App\Models\CustomerPayment::sum('amount') }}</span></h2>
                    </div>
                </div>
            </div>

              <div class="col-md-4 " colspan="2">
                <div class="card border-danger  mb-4 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Debit</h5>

                        <hr>
                        <h2 class="card-text text-danger"><i class="fa-solid fa-credit-card"></i><span class="h3 mx-4 float-end">{{ App\Models\PurchaseRequistion::where('status','confirmed')->sum('amount') +  App\Models\Payment::sum('amount')}}</span></h2>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
