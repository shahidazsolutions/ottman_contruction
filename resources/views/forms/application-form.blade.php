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
                            <h3>Application Form
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
                        @if($isset_id == 1)

                        <div class="card-header pb-0">
                            <h5>Application Form</h5>
                        </div>
                        {{-- edit --}}
                        <div class="card-body">
                            {{-- method="GET" action="{{route('form.add-application')}}" enctype="multipart/form-data"
                            --}}
                            <form class="row gx-3" id="" action="{{route('form.add-application')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$customer_detail->id}}" name="current_customer_id">
                                <input type="hidden" value="{{$flat_detail->id}}" name="current_flat_id">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label>Payment By  <span class="text-danger">*</span> </label>
                                            <input type="text"
                                                class="form-control @error('payment_by') is-invalid @enderror"
                                                value="{{ old('payment_by') }}" name="payment_by">
                                            {{-- <span id="payment_by" class="text-danger errorMessageBox fw-bold"></span> --}}
                                            @error('payment_by')
                                            <span class="text-danger">{{ $message }}</span>

                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Number <span class="text-danger">*</span> </label>
                                            <input type="number"
                                                class="form-control @error('number') is-invalid @enderror"
                                                value="{{ old('number') }}" name='number'>
                                            {{-- <span id="number" class="text-danger errorMessageBox fw-bold"></span> --}}
                                            @error('number')
                                            <span class="text-danger">{{ $message }}</span>

                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label>Dated <span class="text-danger">*</span></label>
                                            <input type="date" disabled value="{{date('Y-m-d')}}"
                                                class="shadow-none bg-transparent form-control @error('date') is-invalid @enderror"
                                                value="{{ old('date') }}" name='date'>
                                            {{-- <span id="date" class="text-danger errorMessageBox fw-bold"></span> --}}
                                            @error('date')
                                            <span class="text-danger">{{ $message }}</span>

                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label>Drawn on Bank Branch </label>
                                            <input type="text"
                                                class="form-control @error('bank_branch') is-invalid @enderror"
                                                value="{{ old('bank_branch') }}" name='bank_branch'>
                                            {{-- <span id="bank_branch" class="text-danger errorMessageBox fw-bold"></span> --}}
                                            @error('bank_branch')
                                            <span class="text-danger">{{ $message }}</span>

                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <div
                                            style="width: 250px; height: 250px; overflow: hidden; display: flex; justify-content: center; border-radius:35px; margin: auto; border:1px solid #888;">
                                            @if ($customer_detail->image)

                                            <img src="{{asset('images/customer')}}/{{ $customer_detail->image }}"
                                            alt="">

                                            @else
                                            <img src="{{asset('images/user.jpeg')}}"
                                            alt="">

                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="form-group">
                                            <label>Flat Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $flat_detail->floor_number }} {{ $flat_detail->room_number }}"
                                                name='mobile_number'>

                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Flat/Shop Size <span class="text-danger">*</span></label>
                                            <input type="number" step="any" class="form-control bg-transparent" disabled
                                                value="{{ $flat_detail->flate_size }}" name='flat_size'>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Flat Preference </label>
                                            <input type="text"
                                                class="form-control @error('flat_preference') is-invalid @enderror"
                                                value="{{ old('flat_preference') }}" name='flat_preference'>
                                            <span id="flat_preference"
                                                class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Payment Schedule <span class="text-danger">(in month) </span>
                                                    </label>
                                                    <input type="number" id="month"
                                                        placeholder="Payment schedule (eg:1 , 3 , 6 ,12  )" step="any"
                                                        class="form-control @error('payment_schedule') is-invalid @enderror"
                                                        value="{{ old('payment_schedule') }}" name='payment_schedule'>
                                                    {{-- <span id="payment_schedule"
                                                        class="text-danger errorMessageBox fw-bold"></span> --}}
                                                        @error('payment_schedule')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Flat Price <span class="text-danger">*</span></label>
                                                    <input type="number" step="any" readonly id="flat_price"
                                                        value="{{ $flat_detail->unit_price*$flat_detail->flate_size }}"
                                                        placeholder="0"
                                                        class="form-control @error('flat_price') is-invalid @enderror"
                                                        value="{{ old('flat_price') }}" name='flat_price'>
                                                    <span id="total_rate"
                                                        class="text-danger errorMessageBox fw-bold"></span>
                                                    @error('flat_price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Installment Amount </label>
                                                    <input type="number" step="any" id="installment" placeholder="0"
                                                        class="form-control @error('installment') is-invalid @enderror"
                                                        value="{{ old('installment') }}"
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
                                            <label>Name Of Applicant <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $customer_detail->name }}" name='applicant_name'>
                                                @error('applicant_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>CNIC <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control bg-transparent" disabled
                                                value="{{ $customer_detail->nic }}" name='applicant_cnic'>

                                                @error('applicant_cnic')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>S/o., W/o. <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $customer_detail->fname }}" name='so_wo'>


                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Phone Number Office </label>
                                            <input type="number" class="form-control bg-transparent" disabled
                                                value="{{ $customer_detail->office_number }}"
                                                name='office_phone_number'>

                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Res:</label>
                                            <input type="text" class="form-control bg-transparent" disabled
                                                value="{{ $customer_detail->res_number }}" name='res_number'>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label>Mobile <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control bg-transparent" disabled
                                                value="{{ $customer_detail->mobile_number }}" name='mobile_number'>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Addrress</label>
                                            <textarea disabled name="mailing_address" id="" cols="30" rows="3"
                                                class="form-control bg-transparent">{{ $customer_detail->address }}</textarea>
                                        </div>
                                    </div>
                                    <h5 class="my-4 mb-2">Nominee <span class="text-danger">*</span></h5>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Name of Nominee</label>
                                            <input type="text"
                                                class="form-control @error('nominee_name') is-invalid @enderror"
                                                value="{{ old('nominee_name') }}" name='nominee_name'>
                                            {{-- <span id="nominee_name" class="text-danger errorMessageBox fw-bold"></span> --}}
                                                @error('nominee_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                        </div>

                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>S/o., W/o. <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('nominee_so_wo') is-invalid @enderror"
                                                value="{{ old('nominee_so_wo') }}" name='nominee_so_wo'>
                                            {{-- <span id="nominee_so_wo" class="text-danger errorMessageBox fw-bold"></span> --}}
                                            @error('nominee_so_wo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Relation with Applicant <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('nominee_relation') is-invalid @enderror"
                                                value="{{ old('nominee_relation') }}" name='nominee_relation'>
                                            {{-- <span id="nominee_relation"
                                                class="text-danger errorMessageBox fw-bold"></span>
                                                 --}}
                                                 @error('nominee_relation')
                                                 <span class="text-danger">{{ $message }}</span>
                                             @enderror

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Nominee CNIC No. <span class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('nominee_cnic') is-invalid @enderror"
                                                value="{{ old('nominee_cnic') }}" name='nominee_cnic'>
                                            <span id="nominee_cnic" class="text-danger errorMessageBox fw-bold"></span>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Payment</label>
                                            <input type="number"
                                                class="form-control @error('paid_amount') is-invalid @enderror"
                                                value="{{ old('paid_amount') }}" name='paid_amount' placeholder="paid amount">
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
                                    {{-- <a href="{{route('items.all')}}"
                                        class="btn btn-pill btn-gradient color-4">Back</a> --}}
                                </div>
                            </form>
                        </div>

                        @else
                        <div class="card-header pb-0">
                            <h5>Application Form</h5>
                        </div>
                        <div class="card-body admin-form">
                            <form class="row gx-3 align-items-center" id="select_application_form">
                                @csrf
                                <div class="input-group">
                                    <div class="form-group col-sm-4">
                                        <label>Customer</label>
                                        <select class="form-select" name="customer_id[]" id=""
                                            value="old('customer_id.0')">
                                            <option selected value="" disabled>Select Customer</option>
                                            @foreach ($all_customers as $customer)
                                            <option value="{{$customer->id}}"
                                                @selected(old('customer_id.0')==$customer->id) >{{$customer->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span id="customer_id" class="text-danger errorMessageBox fw-bold"></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="form-group col-sm-4">
                                        <label>Projects</label>
                                        <select class="form-select projects" name="project_id[]" id=""
                                            value="old('project_id.0')">
                                            <option selected value="" disabled>Select Project</option>
                                            @foreach ($projects as $project)
                                            <option value="{{$project->id}}" onclick="select_project()">
                                                {{$project->project_name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="project_id" class="text-danger errorMessageBox fw-bold"></span>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div class="form-group col-sm-4">
                                        <label>Flats</label>
                                        <select class="form-select all_flats" name="flat_id[]" id=""
                                            value="old('flat_id.0')">
                                            <option selected value="" disabled>Select Project</option>
                                            {{-- // From JS Response --}}
                                        </select>
                                        <span id="flat_id" class="text-danger errorMessageBox fw-bold"></span>
                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <input type="submit" class="btn btn-pill btn-gradient color-4 mt-4" value="Submit">
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid end -->
    </div>
</div>
@push('custom-scripts')
<script>
    $(document).ready(function(){
            $(document).on('change','.projects',function(){
                $.ajax({
                    url: "{{route('sub.change_flat_option')}}",
                    method:"POST",
                    data: {id: $(this).val(),_token:"{{csrf_token()}}"},
                    success: function(res){
                        console.log(res);
                        if(res.success){
                            // $(".all_flats").removeAttr("disabled","")
                            $(".all_flats").html('<option selected value="" disabled>Select Flat</option>');
                            for(let count in res.success){
                                let flats = res.success[count];
                                $(".all_flats").append(`<option value="${flats['id']}">${flats['floor_number']} ${flats['room_number']}</option>`);
                            }

                        }
                        if(res.error){
                            $(".all_flats").html(`<option value="" disabled>${res.error.message}</option>`);
                            // for(let count in res.error){
                            //     let flats = res.error[count];
                            // }
                        }
                    }
                })
            });
            $(document).on("submit", "#select_application_form", function(e){
                e.preventDefault();
                let _this= $(this);
                _this.find('button').attr("disabled",'');
                let formData = new FormData(this);
                formData.append("_token","{{csrf_token()}}");

                $.ajax({
                    url: "{{route('form.application-get')}}",
                    method: 'POST',
                    data: formData,
                    contentType:false,
                    processData: false,
                    success:function(res){
                        _this.find('button').removeAttr("disabled",'');
                        $(".errorMessageBox").html(null);
                        if(res.success){
                            console.log(res.isset, res.customer_id[0], res.flat_id[0]);
                            window.location.href='/application-form/'+res.isset+"/"+res.customer_id[0]+"/"+res.flat_id[0];
                        }
                        if(res.error){
                            console.log(res.error);
                            for (let errorId in res.error) {
                                let errorMessage = res.error[errorId];
                                $(`#${errorId}`).html(errorMessage);
                            }
                        }
                    },
                    error: function(error) {
                        _this.find('button').removeAttr("disabled",'');
                        console.log(error.responseJSON.message);
                    }
                });
            });
            $(document).on("submit", "#add-application-form", function(e){
                e.preventDefault();
                let _this= $(this);
                _this.find('button').attr("disabled",'');
                let formData = new FormData(this);
                formData.append("_token","{{csrf_token()}}");
                $.ajax({
                    url:"{{route('form.add-application')}}",
                    method:"POST",
                    data: formData,
                    contentType:false,
                    processData: false,
                    success:function(res){
                        _this.find('button').removeAttr("disabled",'');
                        $(".errorMessageBox").html(null);
                        if(res.success){
                            console.log(res.success);
                            window.location="{{route('form.all-app-forms')}}";
                        }
                        if(res.error){
                            console.log(res.error);
                            for (let errorId in res.error) {
                                let errorMessage = res.error[errorId];
                                $(`#${errorId}`).html(errorMessage);
                            }
                        }
                    },
                    error: function(error) {
                        _this.find('button').removeAttr("disabled",'');
                        console.log(error.responseJSON.message);
                    }
                });
            })

            $(document).on("submit", "#edit-application-form", function(e){
                e.preventDefault();
                let _this= $(this);
                _this.find('button').attr("disabled",'');
                let formData = new FormData(this);
                formData.append("_token","{{csrf_token()}}");
                $.ajax({
                    url:"{{route('form.edit-app-forms')}}",
                    method:"POST",
                    data: formData,
                    contentType:false,
                    processData: false,
                    success:function(res){
                        _this.find('button').attr("type",'button');
                        _this.find('button').text("Goto All Forms");
                        _this.find('button').removeAttr("disabled",'');
                        _this.find('button').attr("onclick","window.location.href='{{route('form.all-app-forms')}}'");
                        $(".errorMessageBox").html(null);
                        if(res.success){
                            console.log(res.success);
                            // window.location="{{route('form.all-app-forms')}}";
                        }
                        if(res.error){
                            console.log(res.error);
                            for (let errorId in res.error) {
                                let errorMessage = res.error[errorId];
                                $(`#${errorId}`).html(errorMessage);
                            }
                        }
                    },
                    error: function(error) {
                        _this.find('button').removeAttr("disabled",'');
                        console.log(error.responseJSON.message);
                    }
                });
            });

            $('#month').keyup(function(){
                month = $(this).val() || 0;
                total_price = $('#flat_price').val() || 0;
                installment = total_price/month;
                $('#installment').val(installment.toFixed(2));
            });

            $('#installment').keyup(function(){
                installment_amount = $(this).val() || 0;
                total_price = $('#flat_price').val() || 0;
                month = total_price/installment_amount;
                $('#month').val(month.toFixed(2));
            });

        });
</script>
@endpush
@endsection
