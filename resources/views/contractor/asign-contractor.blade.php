@extends('layouts.app')
@section('title','Contractors')
@section('content')

        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Assign Project
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
                                <h5>Assign Project To Contractor</h5>
                            </div>

                            <div class="card-body admin-form">
                                <form class="row gx-3" method="POST" action="{{ route('contractor.add-asign-contractor') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group col-sm-4">
                                        <label>Project Name</label>
                                        <select name="project" class="form-control">
                                            <option disabled selected>Select Project</option>
                                            @foreach($projects as $project)
                                            <option value="{{$project->id}}">{{$project->project_name}}</option>
                                            @endforeach
                                        </select>
                                        <span id="project" class="text-danger errorMessageBox fw-bold"></span>
                                        @error('project')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror


                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Contractor Name</label>
                                        <select name="contractor" class="form-control">
                                            <option disabled selected>Select Contractor</option>
                                            @foreach($contractors as $contractor)
                                            <option value="{{$contractor->id}}">{{$contractor->name}} {{$contractor->fname}}</option>
                                            @endforeach
                                        </select>
                                        @error('contractor')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Expected Price</label>
                                        <input type="number" min="0" name="amount" class="form-control">
                                        @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-btn col-sm-12">
                                        <button id="success" type="sumbit" class="btn btn-pill btn-gradient color-4">Assign Project</button>
                                        <a href="{{route('contractor.manage')}}" class="btn btn-pill btn-gradient color-4">Back To Contractors</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->
            <script>
                $(document).on("submit", "#addContractor", function(e){
                    e.preventDefault();
                    let url = "{{route('contractor.add-asign-contractor')}}";
                    let formData = new FormData(this);
                    formData.append('_token',"{{csrf_token()}}");
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success:function(res){
                            $(".errorMessageBox").html(null);
                            if(res.error){
                                console.log(res.error);
                                for (let errorId in res.error) {
                                    let errorMessage = res.error[errorId];
                                    $(`#${errorId}`).html(errorMessage);
                                }
                            }
                            if(res.success){
                                window.location="{{route('contractor.manage')}}";
                                // console.log(res.success);
                            }

                        },
                        error: function(error) {
                            console.log(error.responseJSON.message);
                        }
                    })
                })
                //
                // _this.find('button').attr("onclick","window.location.href='{{route('form.all-app-forms')}}'");
            </script>
        </div>

@endsection
