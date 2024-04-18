@extends('layouts.app')

@section('content')
<style>
    .a_link_color{
        color: darkblue;
    }
    .a_link_color:hover{
        color: rgb(119, 119, 238);
    }
</style>
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Projects
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
                                <h5>Project List</h5>
                            </div>

                            <div class="card-body admin-form">
                                <table class="table" id="datatable">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Project Name</th>
                                        <th scope="col">Location</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($project as $data)

                                    <tr>
                                        <th scope="row">{{$index++}}</th>
                                        <td>
                                            <a class="a_link_color" href="{{route('show_products',$data->id)}}"> {{$data->project_name}} </a>
                                        </td>
                                        <td>
                                            <a class="a_link_color" href="{{route('show_products',$data->id)}}">
                                            {{$data->location}} </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->
        </div>

        <script>
            $(document).ready(function () {
                $('#datatable').DataTable();
            });
        </script>
@endsection
