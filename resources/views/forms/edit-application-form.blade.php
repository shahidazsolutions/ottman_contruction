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
                            <h3>Edit Application Form
                                <small>Welcome to admin panel</small>
                            </h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid end -->

        @foreach ($applications as $application)

        <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header pb-0">
                            <h5>Application Form</h5>
                        </div>
                        <div class="card-body">
                            {{-- method="GET" action="{{route('form.add-application')}}" enctype="multipart/form-data"
                            --}}
                            <form action="{{ route('form.application-update',$application->id) }}" method="post" class="row gx-3" id="add-application-form">
                                @csrf
                                @method('PUT')

                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label>Payment By</label>
                                            <input type="text"
                                                class="form-control @error('payment_by') is-invalid @enderror"
                                                value="{{ $application->payment_by }}" name="payment_by">
                                            <span id="payment_by" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Number</label>
                                            <input type="number"
                                                class="form-control @error('number') is-invalid @enderror"
                                                value="{{ $application->number }}" name='number'>
                                            <span id="number" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Dated</label>
                                            <input type="date" disabled
                                                class="shadow-none bg-transparent form-control @error('date') is-invalid @enderror"
                                                value="{{ $application->date }}" name='date'>
                                            <span id="date" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Drawn on Bank Branch</label>
                                            <input type="text"
                                                class="form-control @error('bank_branch') is-invalid @enderror"
                                                value="{{ $application->bank_branch }}" name='bank_branch'>
                                            <span id="bank_branch" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <div
                                            style="width: 250px; height: 250px; overflow: hidden; display: flex; justify-content: center; border-radius:35px; margin: auto; border:1px solid #888;">
                                            <img src="{{asset('images/customer/'.$application->customer->image)}}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label>Flat Number</label>
                                            {{-- <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $flat_detail->floor_number }} {{ $flat_detail->room_number }}"
                                                name='mobile_number'> --}}
                                             {{-- <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $flat_detail->floor_number }} {{ $flat_detail->room_number }}"
                                                name='mobile_number'> --}}

                                                 <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $application->flate->floor_number.$application->flate->room_number }}"
                                                name='flat_number'>

                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Flat/Shop Size</label>
                                            {{-- <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $flat_detail->flate_size }}" name='flat_size'> --}}

                                                <input type="number" class="form-control bg-transparent" disabled
                                                value="{{ $application->flate->flate_size }}" name='flat_size'>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Flat Preference</label>
                                            <input type="text"
                                                class="form-control @error('flat_preference') is-invalid @enderror"
                                                value="{{ $application->flat_preference }}" name='flat_preference'>
                                            <span id="flat_preference"
                                                class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="form-group">
                                            <label>Payment Schedule</label>
                                            <input type="text"
                                                class="form-control @error('payment_schedule') is-invalid @enderror"
                                                value="{{ $application->payment_schedule }}" name='payment_schedule'>
                                            <span id="payment_schedule"
                                                class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div> --}}


                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Payment Schedule <span class="text-danger">(in month)</span>
                                                    </label>
                                                    <input type="number" id="month"
                                                        placeholder="Payment schedule (eg:1 , 3 , 6 ,12  )"
                                                        class="form-control @error('payment_schedule') is-invalid @enderror"
                                                        value="{{ $application->payment_schedule }}" name='payment_schedule'>
                                                    {{-- <span id="payment_schedule"
                                                        class="text-danger errorMessageBox fw-bold"></span> --}}
                                                        @error('payment_schedule')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Flat Price</label>
                                                    <input type="number" readonly id="flat_price"
                                                        value="{{ $application->total_amount }}"
                                                        placeholder="0"
                                                        class="form-control @error('flat_price') is-invalid @enderror"
                                                         name='flat_price'>
                                                    <span id="total_rate"
                                                        class="text-danger errorMessageBox fw-bold"></span>
                                                    @error('flat_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Installment Amount</label>
                                                    <input type="number" id="installment" placeholder="0"
                                                        class="form-control @error('installment') is-invalid @enderror"
                                                        value="{{ $application->installment }}"
                                                        name='installment'>
                                                    <span id="installment"
                                                        class="text-danger errorMessageBox fw-bold"></span>
                                                    @error('installment')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-7">
                                        <div class="form-group">

                                            <label>Name Of Applicant</label>
                                            {{-- customer name --}}
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $application->customer->name }}" name='applicant_name'>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>CNIC#</label>
                                            {{-- customer nic --}}
                                            <input type="number" class="form-control bg-transparent" disabled
                                                value="{{ $application->customer->nic }}" name='applicant_cnic'>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>S/o., W/o.</label>
                                            {{-- customer info --}}
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $application->customer->fname }}" name='so_wo'>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Phone Number Office</label>
                                            {{-- customer info --}}
                                            <input type="number" class="form-control bg-transparent" disabled
                                                value="{{  $application->customer->office_number  }}"
                                                name='office_phone_number'>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Res:</label>
                                            {{-- customer info --}}
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $application->customer->res_number }}" name='res_number'>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Mobile</label>
                                            {{-- customer info --}}
                                            <input type="number" class="form-control bg-transparent" disabled
                                                value="{{ $application->customer->phone }}" name='mobile_number'>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Mailing Addrress</label>
                                            {{-- customer infop --}}
                                            <textarea disabled name="" id="" cols="30" rows="3"
                                                class="form-control bg-transparent">{{ $application->customer->address }}</textarea>
                                        </div>
                                    </div>
                                    <h5 class="my-4 mb-2">Nominee</h5>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name of Nominee</label>
                                            <input type="text"
                                                class="form-control @error('nominee_name') is-invalid @enderror"
                                                value="{{ $application->nominee_name }}" name='nominee_name'>
                                            <span id="nominee_name" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>S/o., W/o.</label>
                                            <input type="text"
                                                class="form-control @error('nominee_so_wo') is-invalid @enderror"
                                                value="{{ $application->nominee_so_wo }}" name='nominee_so_wo'>
                                            <span id="nominee_so_wo" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Relation with Applicant</label>
                                            <input type="text"
                                                class="form-control @error('nominee_relation') is-invalid @enderror"
                                                value="{{ $application->nominee_relation }}" name='nominee_relation'>
                                            <span id="nominee_relation"
                                                class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nominee CNIC No.</label>
                                            <input type="number"
                                                class="form-control @error('nominee_cnic') is-invalid @enderror"
                                                value="{{ $application->nominee_cnic }}" name='nominee_cnic'>
                                            <span id="nominee_cnic" class="text-danger errorMessageBox fw-bold"></span>
                                            @error('nominee_cnic')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Paid Amount</label>
                                            <input type="number"
                                                class="form-control @error('paid_amount') is-invalid @enderror"
                                                value="{{ $application->paid_amount }}" name='paid_amount' placeholder="paid amount">
                                            <span id="paid_amount" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        I Have read all term and Conditions with this application form and I hereby agree to abide by
                                        these as well as all ezxosting and future Ottoman Tower rules and regulation.

                                    </div>
                                    <div class="col-3"></div>

                                </div>
                                <div class="form-btn col-sm-12">
                                    <button id="success" type="submit"
                                        class="btn btn-pill btn-gradient color-4 px-5 py-2">Submit Form</button>
                                    <span id="current_customer_id" class="text-danger errorMessageBox fw-bold"></span>
                                    <span id="current_flat_id" class="text-danger errorMessageBox fw-bold"></span>
                                </div>
                            </form>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Container-fluid end -->
    </div>
</div>
@push('custom-scripts')
<script>
    $(document).ready(function(){
        $('#month').keyup(function(){
                month = $(this).val() || 0;
                total_price = $('#flat_price').val() || 0;
                installment = total_price/month;
                $('#installment_amount').val(installment);
            });

            $('#installment_amount').keyup(function(){
                installment_amount = $(this).val() || 0;
                total_price = $('#flat_price').val() || 0;
                month = total_price/installment_amount;
                $('#month').val(month);
            });
    });
</script>

@endpush
@endsection
