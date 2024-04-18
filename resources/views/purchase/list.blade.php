@extends('layouts.app')

@section('content')
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Purchase
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
                                <h5>Purchase List</h5>
                            </div>

                            <div class="card-body admin-form">
                                <table class="table" id="datatable">
                                    <thead>
                                      <tr>
                                        <th >#</th>
                                        <th >Project Name</th>
                                        <th >Employee</th>
                                        <th >Supplier</th>
                                        <th >Purchase Date</th>
                                        <th >Amount</th>
                                        <th style="text-align: end;">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($purchase as $data)

                                    <tr>
                                        <th scope="row">{{$index++}}</th>
                                        @php
                                           $project = \App\Models\Project::find($data->purchase_requistion->project_id);
                                        @endphp
                                        <td> {{ $project->project_name}} </td>
                                        <td>{{$data->employee->name}}</td>
                                        <td>{{$data->supplier->name}}</td>
                                        <td>{{$data->created_at}}</td>
                                        <td>{{$data->purchase_requistion->total_amount}}</td>
                                        <td style="text-align: end;">
                                            <a class="btn btn-dashed-second btn-pill color-2" title="View"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{route('purchase.delete',$data->id)}}" class="btn btn-dashed-second btn-pill color-4" title="Delete"><i class="fa-solid fa-trash"></i></a>
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
