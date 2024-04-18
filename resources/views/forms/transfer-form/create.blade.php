@extends('layouts.app')
@section('content')
<div>

    <div class="page-body">
        <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-header-left">
                            <h3>Transfer From
                                <small>Welcome to admin panel</small>
                            </h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid end -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between">
                            <h5>Transfer Form</h5>

                            <a href="{{ route('form.transfer.index') }}" class="btn btn-dashed btn-pill color-4">View Transfers</a>
                        </div>
                        <div class="card-body">

                            <form class="row gx-3" action="{{ route('form.transfer.store') }}" method="POST" id="">
                                @csrf
                               @foreach ($customer_a as $customer)
                                <input type="hidden" value="{{ $customer->id }}" name="old_customer_id">
                                 <input type="hidden" value="{{ $flat_id }}" name="flat_id">

                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="bg-primary w-50 px-2 py-2 text-white text-center" style="border-top-right-radius: 20px;border-bottom-right-radius:20px;">Party A</h3>
                                    </div>
                                    <div class=" col-sm-9 col-md-9 col-lg-9 col-12 order-sm-1 order-md-1 order-lg-1 order-2">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span> </label>
                                            <input type="text" disabled class="form-control" placeholder="Party A customer name" value="{{ $customer->name }}" name="name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Contact <span class="text-danger">*</span> </label>
                                            <input type="number" disabled class="form-control " value="{{ $customer->mobile_number }}" placeholder="Party A contact number" name="contact">
                                            @error('contact')
                                                <span class="text-danger">*</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Address <span class="text-danger">*</span> </label>
                                            <input type="text"  disabled value="{{ $customer->address }}" placeholder="Enter party A address" class="form-control " name="address">

                                        </div>



                                    </div>
                                    {{-- user profile --}}
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-12 float-right order-md-2 order-sm-2 order-md-2 order-lg-2 order-1">
                                        <div class="mt-2" style="width: 100%; height: 90%; overflow: hidden;  border-radius:35px; border:1px solid #888;">
                                            @if ($customer->image)

                                            <img style="width: 100%;height: 100%;" src="{{ asset('images/customer/'.$customer->image) }}" alt="">
                                            @else
                                            <img style="width: 100%;height: 100%;" src="{{ asset('images/user.jpeg') }}" alt="">

                                            @endif

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-">
                                        <div class="form-group">
                                            <label>Nominee <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" placeholder="Enter party A nominee" readonly value="{{ $customer->booking($customer->id,$flat_id)->nominee_name }}" name="old_customer_nominee">
                                            @error('old_customer_nominee')
                                                    <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Payment Recieve <span class="text-danger">*</span> </label>

                                            <input type="number" class="form-control" placeholder="Enter party A recieve payment" readonly value="{{  formatAmount($customer->booking($customer->id,$flat_id)->paid_amount + $customer->flatPayment($customer->id,$flat_id)->sum('amount'))   }}" name="old_customer_payment">
                                            @error('old_customer_payment')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Cnic <span class="text-danger">*</span> </label>
                                            <input type="number" disabled class="form-control" placeholder="Enter party A cnic number" value="{{ $customer->nic }}" name="old_customer_nic">

                                            @error('old_customer_nic')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                               @endforeach


                                <hr>

                                @foreach ($customer_b as $customer)

                                <input type="hidden"  name="new_customer_id" value="{{ $customer->id }}" id="">
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="bg-primary w-50 px-2 py-2 text-white text-center" style="border-top-right-radius: 20px;border-bottom-right-radius:20px;">Party B</h3>
                                    </div>
                                    <div class=" col-sm-9 col-md-9 col-lg-9 col-12 order-sm-1 order-md-1 order-lg-1 order-2">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span> </label>
                                            <input type="text" disabled class="form-control" placeholder="Party B customer name" value="{{ $customer->name }}" name="name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Contact <span class="text-danger">*</span> </label>
                                            <input type="number" disabled class="form-control " value="{{ $customer->mobile_number }}" placeholder="Party B contact number" name="contact">
                                            @error('contact')
                                                <span class="text-danger">*</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Address <span class="text-danger">*</span> </label>
                                            <input type="text" disabled value="{{ $customer->address }}" placeholder="Enter party B address" class="form-control " name="address">
                                            <span id="date" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>



                                    </div>
                                    {{-- user profile --}}
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-12 float-right order-md-2 order-sm-2 order-md-2 order-lg-2 order-1">
                                        <div class="mt-2" style="width: 100%; height: 90%; overflow: hidden;  border-radius:35px; border:1px solid #888;">
                                            @if ($customer->image)

                                            <img style="width: 100%;height: 100%;" src="{{ asset('images/customer/'.$customer->image) }}" alt="">
                                                @else
                                                <img style="width: 100%;height: 100%;" src="{{ asset('images/user.jpeg') }}" alt="">

                                            @endif


                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nominee <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" placeholder="Enter party B nominee" value="{{ old('new_customer_nominee') }}" name="new_customer_nominee">
                                            @error('new_customer_nominee')
                                                    <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Payment Recieve <span class="text-danger">*</span> </label>
                                            <input type="number" class="form-control" placeholder="Enter party B recieve payment" value="{{ old('new_customer_payment') }}" name="new_customer_payment">
                                            @error('new_customer_payment')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Cnic <span class="text-danger">*</span> </label>
                                            <input type="number" disabled class="form-control" placeholder="Enter party B cnic number" value="{{ $customer->nic }}" name="new_customer_nic">

                                            @error('new_customer_nic')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary float-end  ">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@push('custom-scripts')

@endpush
@endsection
