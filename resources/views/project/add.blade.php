@extends('layouts.app')
@section('content')
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>New Project</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h5>Add Project</h5>
                            </div>
                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{ route('project.insert-project') }}" >
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label>Project Name <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="enter project name" class="form-control @error('project_name') is-invalid @enderror" value="{{ old('project_name') }}" name="project_name" >
                                        @error('project_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Location <span class="text-danger">*</span> </label>
                                        <input type="text" placeholder="enter project location" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}">
                                        @error('location')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Expected Amount <span class="text-danger">*</span> </label>
                                        <input type="number" step="any" placeholder="enter project expected amount" min="0" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}">
                                        @error('amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Description(Optional)</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="enter project description"  name="description" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @endif
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4 px-5">Add Project</button>
                                        <a  href="{{ route('project.all-projects') }}" class="btn btn-pill btn-gradient color-4 px-5 float-end">Back</a>
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
