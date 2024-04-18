@extends('layouts.app')
@section('content')
<div>

    <div class="page-body">
        <!-- Container-fluid start -->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-header-left">
                            <h3>All Transfer Forms
                                <small>Welcome to admin panel</small>
                            </h3>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid end -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header p-3 d-flex align-items-center justify-content-between">
                            <h5>All Forms</h5>
                            <button type="button" class="btn btn-dashed btn-pill color-4"
                                onclick="window.location='{{route('form.find-customer')}}'">ADD</button>
                        </div>
                        <div class="card-body table-responsive p-3">
                            <table class="table table-hovered table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Party A</th>
                                        <th>Party B</th>
                                        <th>Flat</th>
                                        <th>More</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfers as $key=> $transfer)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $transfer->oldCustomer->name }}</td>
                                                <td>{{ $transfer->newCustomer->name }}</td>
                                                <td>{{ $transfer->flat->floor_number.$transfer->flat->room_number }}</td>
                                                <td>
                                                     <a class="btn btn-dashed btn-pill color-6"
                                                href="{{ route('form.transfer.edit',$transfer->id) }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>



                                         <!--    <a class="btn btn-dashed btn-pill color-6"-->
                                         <!--    >-->
                                         <!--    <i class="fa-solid fa-trash"></i>-->
                                         <!--</a>-->
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
    </div>

</div>
@push('custom-scripts')
<script>




</script>
@endpush
@endsection
