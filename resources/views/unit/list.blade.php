@extends('layouts.app')

@section('content')
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Unit
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
                                <h5>Unit List</h5>
                            </div>
                            
                            <div class="card-body admin-form">
                                <table class="table" id="datatable">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"> Name</th>
                                        <th scope="col" style="text-align: end;">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($unit as $data)
                                        
                                    <tr>
                                        <th scope="row">{{$index++}}</th>
                                        <td>{{$data->name}}</td>
                                        <td style="text-align: end;">
                                            <a href="{{route('unit.edit',$data->id)}}" class="btn btn-dashed btn-pill color-6"><i class="fa-solid fa-pen-to-square"></i></a>
                                            @php
                                                $reqs = \App\Models\PurchaseRequistionItem::where('unit_id', $data->id)->first();
                                            @endphp
                                            @isset($reqs)
                                            @else
                                            <a href="{{route('unit.delete',$data->id)}}" class="btn btn-dashed btn-pill color-4"><i class="fa-solid fa-trash"></i></a>
                                            @endif
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