@extends('layouts.app')

@section('onsite_al_active')
active
@endsection
@inject('Almost', 'App\Http\Controllers\OnSiteAlController')

@section('content')
<div class="container">
    {{-- @include('layouts.warning_almost') --}}
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>On Site ALMOST SLA</strong></div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('/onsite_al') }}" class="btn btn-link pull-right">
                        <span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    @include('onsite_al.filter')
                    <hr />
                    {{-- <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div> --}}
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Detail of cases on-site almost 24 hr</h3>
                        <table class="table table-condensed table-halmost">
                            <thead>
                                <tr>
                                    <th nowrap style="width: 108px;">Ticket No.</th>
                                    <th nowrap>วัน-เวลา</th>
                                    <th nowrap>หน่วยงาน</th>
                                    <th nowrap>ชื่อผู้แจ้ง</th>
                                    <th nowrap>รายละเอียดปัญหา</th>
                                    <th nowrap>ระยะเวลาที่เหลือก่อนครบกำหนด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($almostIn as $in)
                                    <tr>
                                        <td><a href="{{ url('/job/'.$in->id) }}">{{ $in->ticket_no }}</a></td>
                                        <td>{{$in->created_at}}</td>
                                        <td>{{$in->department->name}}</td>
                                        <td>{{$in->informer_name}}</td>
                                        <td>{{$in->description}}</td>
                                        <td>{{$Almost::datediffHr(date('Y-m-d H:i:s'),date('Y-m-d H:i:s', strtotime($in->created_at.'+1 Day')))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$almostIn->appends(['project'=>request()->query('project'),'department'=>request()->query('department'),'almostEnd' => $almostEnd->currentPage()])->links()}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{-- @include('onsite.filter') --}}
                    <hr />
                    {{-- <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div> --}}
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Detail of cases on-site almost 48 hr</h3>
                        <table class="table table-condensed table-halmost">
                            <thead>
                                <tr>
                                    <th nowrap style="width: 108px;">Ticket No.</th>
                                    <th nowrap>วัน-เวลา</th>
                                    <th nowrap>หน่วยงาน</th>
                                    <th nowrap>ชื่อผู้แจ้ง</th>
                                    <th nowrap>รายละเอียดปัญหา</th>
                                    <th nowrap>ระยะเวลาที่เหลือก่อนครบกำหนด</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($almostEnd as $end)
                                    <tr>
                                        <td><a href="{{ url('/job/'.$end->id) }}">{{ $end->ticket_no }}</a></td>
                                        <td>{{$end->created_at}}</td>
                                        <td>{{$end->department->name}}</td>
                                        <td>{{$end->informer_name}}</td>
                                        <td>{{$end->description}}</td>
                                        <td>{{$Almost::datediffHr(date('Y-m-d H:i:s'),date('Y-m-d H:i:s', strtotime($end->created_at.'+1 Day')))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                        {{$almostEnd->appends(['project'=>request()->query('project'),'department'=>request()->query('department'),'almostIn' => $almostIn->currentPage()])->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection