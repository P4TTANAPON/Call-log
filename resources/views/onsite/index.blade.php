@extends('layouts.app')

@section('onsite_active')
active
@endsection

@section('content')
<div class="container">
    {{-- @include('layouts.warning_almost') --}}
    <div class="panel panel-primary">
        <div class="panel-heading"><strong>On Site</strong></div>
        <div class="panel-body">
            
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ url('/onsite/export') }}{{ empty(explode('?', $_SERVER['REQUEST_URI'])[1]) ? '' : '?'.explode('?', $_SERVER['REQUEST_URI'])[1] }}" class="btn btn-link pull-right">
                        <span class="glyphicon glyphicon-export"></span> Export</a>
                    @include('onsite.filter')
                    <hr />
                    {{-- <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div> --}}
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Detail of cases on-site IN 24 hr</h3>
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th nowrap style="width: 108px;">Ticket No.</th>
                                    <th nowrap>วัน-เวลา</th>
                                    <th nowrap>หน่วยงาน</th>
                                    <th nowrap>ชื่อผู้แจ้ง</th>
                                    <th nowrap>รายละเอียดปัญหา</th>
                                    <th nowrap>status</th>
                                    <th nowrap>ผู้ดูแล</th>
                                    {{-- <th nowrap>debug</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($in24 as $in)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/job/'.$in->id) }}">{{ $in->ticket_no }}</a>
                                            @if($in->isSla())
                                                <?php $progress = $in->progress(); ?>
                                                <div class="progress" style="margin-bottom: 5px">
                                                    <div class="progress-bar
                                                    {{ $progress['p'] >= 100 ? 'progress-bar-danger' : ''}}
                                                    {{ $progress['p'] >= 70 && $progress['p'] < 100 ? 'progress-bar-warning' : 'progress-bar-success' }}
                                                    {{ $in->closed ? '' : 'progress-bar-striped active'}}"
                                                        role="progressbar" style="width: {{ $progress['p'] }}%">
                                                        {{ $progress['p'] > 30 && $progress['p'] < 100 ? $progress['h'] : ($progress['p'] >= 100 ? 'Over SLA' : '') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{$in->created_at}}</td>
                                        <td>{{$in->department->name}}</td>
                                        <td>{{$in->informer_name}}</td>
                                        <td>{{$in->description}}</td>
                                        <td nowrap>
                                            @if($in->closed == true and $in->cc_confirm_closed == true)
                                                <span class="label label-success">Closed</span> 
                                            @elseif($in->closed == true and $in->cc_confirm_closed == false)
                                                <span class="label label-info">Confirm</span> 
                                            @else
                                                <span class="label label-primary">Active</span> 
                                            @endif
                                        </td>
                                        <td>[{{$in->closed==0? $in->active_operator_team : $in->last_operator_team}}] {{$in->closed==0?  empty($in->active_operator->name)? "": $in->active_operator->name : (empty($in->last_operator->name)? "": $in->last_operator->name)}}</td>
                                        {{-- <td>@if($in->scs_solve_user_dtm == "")hahah @else {{$in->scs_solve_user_dtm}} @endif</td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{$in24->appends(['project'=>request()->query('project'),
                        'department'=>request()->query('department'),
                        'close'=>request()->query('close'),
                        'in48' => $in48->currentPage(),
                        'over48' => $over48->currentPage()])->links()}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{-- @include('onsite.filter') --}}
                    <hr />
                    {{-- <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div> --}}
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Detail of cases on-site BETWEEN 24 - 48 hr</h3>
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th nowrap style="width: 108px;">Ticket No.</th>
                                    <th nowrap>วัน-เวลา</th>
                                    <th nowrap>หน่วยงาน</th>
                                    <th nowrap>ชื่อผู้แจ้ง</th>
                                    <th nowrap>รายละเอียดปัญหา</th>
                                    <th nowrap>status</th>
                                    <th nowrap>ผู้ดูแล</th>
                                    {{-- <th nowrap>debug</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($in48 as $in)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/job/'.$in->id) }}">{{ $in->ticket_no }}</a>
                                            @if($in->isSla())
                                                <?php $progress = $in->progress(); ?>
                                                <div class="progress" style="margin-bottom: 5px">
                                                    <div class="progress-bar
                                                    {{ $progress['p'] >= 100 ? 'progress-bar-danger' : ''}}
                                                    {{ $progress['p'] >= 70 && $progress['p'] < 100 ? 'progress-bar-warning' : 'progress-bar-success' }}
                                                    {{ $in->closed ? '' : 'progress-bar-striped active'}}"
                                                        role="progressbar" style="width: {{ $progress['p'] }}%">
                                                        {{ $progress['p'] > 30 && $progress['p'] < 100 ? $progress['h'] : ($progress['p'] >= 100 ? 'Over SLA' : '') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{$in->created_at}}</td>
                                        <td>{{$in->department->name}}</td>
                                        <td>{{$in->informer_name}}</td>
                                        <td>{{$in->description}}</td>
                                        <td nowrap>
                                            @if($in->closed == true and $in->cc_confirm_closed == true)
                                                <span class="label label-success">Closed</span> 
                                            @elseif($in->closed == true and $in->cc_confirm_closed == false)
                                                <span class="label label-info">Confirm</span> 
                                            @else
                                                <span class="label label-primary">Active</span> 
                                            @endif
                                        </td>
                                        <td>[{{$in->closed==0? $in->active_operator_team : $in->last_operator_team}}] {{$in->closed==0?  empty($in->active_operator->name)? "": $in->active_operator->name : (empty($in->last_operator->name)? "": $in->last_operator->name)}}</td>
                                        {{-- <td>@if($in->scs_solve_user_dtm == "")hahah @else {{$in->scs_solve_user_dtm}} @endif</td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                        {{$in48->appends(['project'=>request()->query('project'),
                                        'department'=>request()->query('department'),
                                        'close'=>request()->query('close'),
                                        'in24' => $in24->currentPage(),
                                        'over48' => $over48->currentPage()])->links()}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{-- @include('onsite.filter') --}}
                    <hr />
                    {{-- <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div> --}}
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Detail of cases on-site OVER 48 hr</h3>
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th nowrap style="width: 108px;">Ticket No.</th>
                                    <th nowrap>วัน-เวลา</th>
                                    <th nowrap>หน่วยงาน</th>
                                    <th nowrap>ชื่อผู้แจ้ง</th>
                                    <th nowrap>รายละเอียดปัญหา</th>
                                    <th nowrap>status</th>
                                    <th nowrap>ผู้ดูแล</th>
                                    {{-- <th nowrap>debug</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($over48 as $over)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/job/'.$over->id) }}">{{ $over->ticket_no }}</a>
                                            @if($over->isSla())
                                                <?php $progress = $over->progress(); ?>
                                                <div class="progress" style="margin-bottom: 5px">
                                                    <div class="progress-bar
                                                    {{ $progress['p'] >= 100 ? 'progress-bar-danger' : ''}}
                                                    {{ $progress['p'] >= 70 && $progress['p'] < 100 ? 'progress-bar-warning' : 'progress-bar-success' }}
                                                    {{ $over->closed ? '' : 'progress-bar-striped active'}}"
                                                        role="progressbar" style="width: {{ $progress['p'] }}%">
                                                        {{ $progress['p'] > 30 && $progress['p'] < 100 ? $progress['h'] : ($progress['p'] >= 100 ? 'Over SLA' : '') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{$over->created_at}}</td>
                                        <td>{{$over->department->name}}</td>
                                        <td>{{$over->informer_name}}</td>
                                        <td>{{$over->description}}</td>
                                        <td nowrap>
                                            @if($over->closed == true and $over->cc_confirm_closed == true)
                                                <span class="label label-success">Closed</span> 
                                            @elseif($over->closed == true and $over->cc_confirm_closed == false)
                                                <span class="label label-info">Confirm</span> 
                                            @else
                                                <span class="label label-primary">Active</span> 
                                            @endif
                                        </td>
                                        <td>[{{$over->closed==0? $over->active_operator_team : $over->last_operator_team}}] {{$over->closed==0?  empty($over->active_operator->name)? "": $over->active_operator->name : (empty($over->last_operator->name)? "": $over->last_operator->name)}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                        {{$over48->appends(['project'=>request()->query('project'),
                                            'department'=>request()->query('department'),
                                            'close'=>request()->query('close'),
                                            'in24' => $in24->currentPage(),
                                            'in48' => $in48->currentPage()])->links()}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection