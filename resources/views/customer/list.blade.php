@extends('layouts.app')

@section('content')
<style>
    .btn-close{
        background: transparent!important;
    }
</style>
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>All Customer
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
                <div class="row agent-section property-section agent-lists">
                    <div class="col-lg-12">
                        <div class="ratio2_3">
                            <div class="property-2 row column-sm property-label property-grid px-3">
                                <table class="table table-bordered table-hovered table-striped " id="datatable">
                                    <thead>
                                            <tr>
                                                <th>Sr</th>
                                                <th>Name</th>
                                                <th>First Name</th>
                                                <th>Number</th>
                                                <th>Nic</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>More</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer as $key=> $data)

                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $data->name }}</td>
                                                    <td>{{ $data->fname }}</td>
                                                    <td>{{ $data->mobile_number }}</td>
                                                    <td>{{ $data->nic }}</td>
                                                    <td>{{ $data->email }}</td>
                                                    <td>{{ $data->address }}</td>
                                                    <td>

                                                        <a class="btn btn-sm btn-dashed btn-pill color-6" href="{{ route('customer.edit',$data->id) }}">
                                                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>

                                                        </a>
                                                        <a class="btn btn-sm btn-dashed btn-pill color-6" data-bs-toggle="modal" data-bs-target="#delete{{ $data->id }}">

                                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                                        </a>


                                                </td>
                                                </tr>

                                                <div class="modal fade" id="delete{{ $data->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{route('customer.remove',$data->id)}}">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close">X</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Do you want to delete this?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                            @endforeach
                                        </tbody>
                                    </table>





                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid end -->
        </div>

@endsection
