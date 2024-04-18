@extends('layouts.app')
@section('title','Members Payment')
@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Members Payment
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
                                <h5>Add Members Payment</h5>
                            </div>

                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{route('admin.members-payment.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label>Name <span class="text-danger">*</span> </label>
                                        <select name="member" class="form-control @error('member') is-invalid @enderror" id="">
                                            <option value="">Select Member</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('member')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>Amount <span class="text-danger">*</span> </label>
                                        <input type="number" step="any" placeholder="Enter amount" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}">
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label>Date <span class="text-danger">*</span> </label>
                                        <input type="date"  class="form-control @error('date') is-invalid @enderror" name="date" value="{{ date('Y-m-d') }}">
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Description  </label>
                                        <textarea name="description" class="form-control" id="" cols="3" rows="2" placeholder="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>


                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Add Payment</button>
                                        <a href="{{route('admin.members-payment.index')}}" class="btn btn-pill btn-gradient color-4">Back To Payments</a>
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
