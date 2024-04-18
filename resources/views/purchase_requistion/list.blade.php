@extends('layouts.app')
@section('content')
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Purchase Requisition
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
                                <h5>Purchase Requisition List</h5>
                            </div>

                            <div class="card-body admin-form">
                                <table class="table" id="datatable">
                                    <thead>
                                      <tr>


                                        <th >ID</th>
                                        <th >Project Name</th>
                                        <th >Supplier</th>
                                        <th >Required Date</th>
                                        <th >Amount</th>
                                        <th >Status</th>
                                        <th style="text-align: end;">Action</th>

                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($purchase_requistion as $data)
                                    {{-- <pre>{{print_r($data, true)}}</pre> --}}
                                    <tr>

                                        <td>
                                            {{ $data->id }}
                                        </td>
                                        <td>{{$data->project->project_name}}</td>
                                        <td>{{ $data->supplier->name." ".$data->supplier->fname }}</td>
                                        {{-- <td>{{$data->employee->name}}</td> --}}
                                        <td>{{$data->required_date}}</td>
                                        <td>{{$data->amount}}</td>
                                        <td class="text-capitalize">{{$data->status}}</td>
                                        <td style="text-align: end;">
                                            @if($data->status == 'pending')
                                                <a href="{{route('purchase-requistion.edit',$data->id)}}" class="btn btn-dashed-second btn-pill  color-6" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{route('purchase-requistion.remove',$data->id)}}" class="btn btn-dashed-second btn-pill color-4" title="Delete"><i class="fa-solid fa-trash"></i></a>
                                                <a href="{{ route('purchase.add',$data->id) }}" >Explore <i class="ms-2 fas fa-arrow-right"></i></a>
                                                @else
                                                <a href="{{ route('purchase-requistion.show',$data->id) }}" class="btn btn-dashed-second btn-pill color-4" title="Delete"><i class="fa-solid fa-eye"></i></a>
                                            @endif
                                            {{-- <a class="btn btn-dashed-second btn-pill color-2" title="View"><i class="fa-solid fa-eye"></i></a> --}}
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
