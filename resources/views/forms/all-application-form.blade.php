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
                            <h3>All Application Forms
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
                                        <th>Applicant Name</th>
                                        <th>Project</th>
                                        <th>Nominee Name</th>
                                        <th>Flat Number</th>
                                        <th>Flat Shop/Size</th>
                                        <th>Flat Preference</th>
                                        {{-- <th>Payment By</th> --}}
                                        {{-- <th>Payment Schedule</th> --}}
                                        {{-- <th>Applicant Number</th> --}}
                                        <th>Applied Date</th>
                                        <th>More</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($customers as $customer)
                                    @foreach ($customer->applications as $key => $application)

                                    @php
                                        $display = '';
                                        $row_id = '';
                                        if($key>0){
                                            $display='d-none';
                                            $row_id=$customer->id;
                                        }
                                    @endphp
                                    <tr id="{{ $row_id }}" class="{{ $row_id }}  {{ $display }}">
                                        @if (!$key>0)
                                            <td>{{ $customer->name }} <br> @if ($customer->applications->count() > 1)

                                             <a href="javascript:void(0)" class="view_more" data-customer_id="{{ $customer->id }}" >View more</a>@endif</td>
                                            @else
                                            <td></td>
                                        @endif
                                        <td>{{ $application->flate->project->project_name }}</td>
                                        <td>{{ $application->nominee_name }}
                                        </td>
                                        <td>{{ $application->flate->floor_number.$application->flate->room_number }}</td>
                                        <td>{{ $application->flate->flate_size }}</td>
                                        <td>{{ $application->flat_preference }}</td>
                                        <td>{{ date('Y-d-m',strtotime($application->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('form.application.invoice',$application->id) }}" class="btn btn-dashed btn-sm btn-pill color-4"
                                                >
                                                <i class="fa-solid fa-print"></i>
                                            </a>

                                        <!--    <button type="button" class="btn btn-dashed btn-sm btn-pill color-4 deleteRow"-->
                                        <!--    row_id="{{$application->id}}">-->
                                        <!--    <i class="fa-solid fa-trash"></i>-->
                                        <!--</button>-->
                                            {{-- <button class="btn btn-dashed btn-pill color-6"
                                                onclick="window.location='{{url('application-form')}}/1/{{$customer->id}}/1/{{$application->flat_id}}'">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button> --}}

                                             <button class="btn btn-dashed btn-sm btn-pill color-6"
                                                onclick="window.location='{{route('form.application-edit',$application->id)}}'">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            {{-- <button class="btn btn-dashed btn-pill color-6 print_btn"
                                                form_id="{{$flat->id}}" flat_id="{{$product->id}}"
                                                customer_id="{{$customer->id}}">
                                                <i class="fa-solid fa-print"></i>
                                            </button> --}}
                                        </td>
                                    </tr>


                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                              ...
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                              <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    @endforeach
                                    @endforeach
                                    {{--
                                    @foreach ($allCustomers as $key => $val)
                                    @php $customer = \App\Models\Customer::find($key); @endphp
                                    <tr class="target-table-row" target="rowOne{{$customer->id}}">
                                        <td colspan="1" class="p-">
                                            <button class="w-100 btn text-start">
                                                {{$customer->name}}
                                            </button>
                                        </td>
                                        <td colspan="9"></td>
                                        <td colspan="1" class="text-end">V</td>
                                    </tr>
                                    @foreach ($val as $innerKey => $innerVal)
                                    @php
                                    $product = \App\Models\Product::find($innerKey);
                                    $project = \App\Models\Project::find($product->project_id);
                                    $flatDetail = \App\Models\FormApplication::whereId($innerVal[0])->get();
                                    @endphp
                                    @foreach ($flatDetail as $flat)
                                    <tr trigger="rowOne{{$customer->id}}" class="trigger-table-row"
                                        style="display: none;">
                                        <td colspan="1" class="text-center">
                                            <button type="button" class="btn btn-dashed btn-pill color-4 deleteRow"
                                                row_id="{{$flat->id}}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <button class="btn btn-dashed btn-pill color-6"
                                                onclick="window.location='{{url('application-form')}}/1/{{$customer->id}}/{{$product->id}}/{{$flat->id}}'">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-dashed btn-pill color-6 print_btn"
                                                form_id="{{$flat->id}}" flat_id="{{$product->id}}"
                                                customer_id="{{$customer->id}}">
                                                <i class="fa-solid fa-print"></i>
                                            </button>
                                        </td>
                                        <td>{{$project->project_name}}</td>
                                        <td>{{$flat->nominee_name}}</td>
                                        <td>{{$product->floor_number}} {{$product->room_number}}</td>
                                        <td>{{$product->flate_size}}</td>
                                        <td>{{$flat->flat_preference}}</td>
                                        <td>{{$flat->payment_by}}</td>
                                        <td>{{$flat->payment_schedule}}</td>
                                        <td>{{$customer->mobile_number}}</td>
                                        <td>{{explode(' ',$flat->created_at)[0]}}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    @endforeach --}}



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
    $(document).on('click', '.deleteRow', function(e){
        let rowid = $(this).attr('row_id');
        let _this = $(this);
        $.ajax({
            url: "/application-form/remove/"+rowid,
            method:"GET",
            data:{id:rowid,_token:"{{csrf_token()}}"},
            success: function(res){
                console.log(res.success)
                if(res.success){
                    $(_this).closest('tr').fadeOut();
                }
            }
        })
    });
    $(document).on('click', '.target-table-row', function(){
        $('.target-table-row').css("background","transparent");
        $('.trigger-table-row').slideUp('fast');
        $(`.trigger-table-row[trigger=${ $(this).attr('target') }]`).slideToggle('slow');
        setTimeout(() => {
            $(this).css("background","#f3f3f3");
        }, 200);
    });
    $(document).on("click",".print_btn",function(){
        let form_id = $(this).attr('form_id');
        let customer_id = $(this).attr('customer_id');
        let flat_id = $(this).attr('flat_id');
        $.ajax({
            url:"{{route('form.print-app-forms')}}",
            method:"POST",
            data:{
                formid: form_id,
                customerid: customer_id,
                flatid: flat_id,
                _token: "{{csrf_token()}}"
            },
            success:function(res){
                console.log(res);
            }
        })
        // console.log(form_id, customer_id, flat_id);

    });




        $(document).on('click', '.view_more', function() {
    var customer_id = $(this).data('customer_id');
    var rows = $('tbody .' + customer_id);
    rows.toggleClass('d-none');
});



</script>
@endpush
@endsection
