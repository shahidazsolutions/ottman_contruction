@extends('layouts.app')

@section('content')
        <div class="page-body">
            <!-- Container-fluid start -->
            <div class="container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="page-header-left">
                                <h3>Assign Projects
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
                            <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                                <h5>Manage Contractors</h5>

                        <a href="{{route('contractor.asign-contractor')}}" class="btn btn-primary btn-sm float-end color-2">Assign Project</a>
                            </div>

                            <div class="card-body admin-form">
                                <table class="table" id="datatable">
                                    <thead>
                                      <tr>
                                        <th >#</th>
                                        <th >Project</th>
                                        <th >contractor</th>
                                        <th >Amount</th>
                                        <th >Payable Balance</th>
                                        <th >Assign Date</th>
                                        <th style="text-align: end;"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($managerContractor as $contractorDetail)
                                    @php
                                        $project = \App\Models\Project::find($contractorDetail->project);
                                        $contractor = \App\Models\Contractor::find($contractorDetail->contractor);
                                    @endphp
                                    <tr>
                                        <th scope="row">{{$index++}}</th>
                                        <td>@if(!empty($project)) {{ $project->project_name }} @endif</td>
                                        <td>@if(!empty($contractor)) {{ $contractor->name }} {{ $contractor->fname }} @endif</td>
                                        <td>{{ formatAmount($contractorDetail->amount) }}</td>
                                        {{-- payable balance --}}
                                        <th>{{  formatAmount($contractorDetail->amount - $contractor->getContractPayment($project->id,$contractor->id)->sum('amount')) ?? 0  }}</th>
                                        <td>{{ explode(' ',$contractorDetail->created_at)[0] }}</td>
                                        <td style="text-align: end;">
                                            <a href={{ route('contractor.contractor-detail',$contractorDetail->id) }} class="btn btn-dashed-second btn-pill color-2 view-contractor"><i class="fa-solid fa-eye"></i></a>
                                            {{-- <a href="" class="btn btn-dashed-second btn-pill color-4" title="Delete"><i class="fa-solid fa-trash"></i></a> --}}
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

@endsection
