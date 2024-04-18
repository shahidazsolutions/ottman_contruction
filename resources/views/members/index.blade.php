@extends('layouts.app')
@section('title','Members')
@section('content')

<div class="page-body">
    <!-- Container-fluid start -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>Members
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
                        <h5>Members List</h5>
                    </div>

                    <div class="card-body admin-form">
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Nic</th>
                                    <th>Phone</th>
                                    <th>Addres</th>
                                    <th>More</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $key=> $member)

                                <tr>
                                    <td scope="row">{{ $key+1 }}</td>
                                    <td scope="row">{{ $member->name }}</td>
                                    <td scope="row">{{ $member->nic }}</td>
                                    <td scope="row">{{ $member->number }}</td>
                                    <td scope="row">{{ $member->address }}</td>
                                    <td>


                                        <a class="btn btn-sm btn-dashed btn-pill color-6"
                                            href="{{ route('admin.members.edit',$member->id) }}">
                                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>

                                        </a>
                                        @if (!$member->payments()->count() > 0 )

                                        <a class="btn btn-sm btn-dashed btn-pill color-6" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $member->id }}">

                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </a>
                                    @endif

                                    </td>
                                </tr>


                                <!-- Modal -->
                                <div class="modal fade" id="delete{{ $member->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.members.destroy',$member->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body">
                                                    <strong>Do you want to delete this?</strong>
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
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid end -->

</div>

@endsection
