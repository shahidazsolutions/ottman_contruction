@extends('layouts.app')
@section('title', 'Projects')
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-header-left">
                        <h3>All Projects</h3>
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
                        <h5>Project List</h5>
                    </div>
                    <div class="card-body report-table ">
                        <div class="table-responsive recent-properties border p-4">
                            <table class="table table-bordernone table-hovered table-bordered table-striped"
                                id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Project Name</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Expected Amount</th>
                                        <th scope="col" style="text-align: end;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project as $data)
                                    <tr>
                                        <th scope="row">{{ $index++ }}</th>
                                        <td>{{ $data->project_name }}</td>
                                        <td>{{ $data->location }}</td>
                                        <td>{{ formatAmount($data->amount) }}</td>
                                        <td style="text-align: end;">
                                            <a href='{{ route("project.edit-project","{$data->id}") }}'
                                                class="btn btn-dashed-second btn-pill color-2"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>

                                            <!--<a class="btn btn-dashed btn-pill color-6" data-bs-toggle="modal"-->
                                            <!--    data-bs-target="#delete{{ $data->id }}">-->

                                            <!--    <i class="fa-solid fa-trash" aria-hidden="true"></i>-->
                                            <!--</a>-->
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="delete{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('project.destroy',$data->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Do you want to delete this?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    </div>
    <!-- Container-fluid end -->
</div>



@endsection
