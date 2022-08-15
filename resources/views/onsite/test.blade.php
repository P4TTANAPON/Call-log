@extends('layouts.app')

@section('content')
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
        </tr>
    </thead>
    <tbody>
        @foreach ($overIn as $in)
            <tr>
                <td><a href="{{ url('/job/'.$in->id) }}">{{ $in->ticket_no }}</a></td>
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
            </tr>
        @endforeach
    </tbody>
</table>
@endsection