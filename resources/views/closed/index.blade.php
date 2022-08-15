@extends('layouts.app')

@section('closed_active')
active
@endsection

@section('table')
<div class="table-responsive">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th nowrap>Ticket No.</th>
				<th nowrap>วัน-เวลา</th>
				<th nowrap>หน่วยงาน</th>
				<th nowrap>ชื่อผู้แจ้ง</th>
				<th nowrap>เบอร์โทรผู้แจ้ง</th>
				<th nowrap>รายละเอียดปัญหา</th>
				<th nowrap>ทีม</th>
				<th nowrap>ผู้ดูแล</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($jobs as $job)
				<tr>
					<td nowrap><a href="/job/{{ $job->id }}">{{ $job->ticket_no }}</a></td>
					<td style="width:86px">{{ $job->created_at }}</td>
					<td nowrap><?php echo str_replace(' ', "<br/>", $job->department->name) ?></td>
					<td style="width:100px">{{ $job->informer_name }}</td>
					<td nowrap>{{ $job->informer_phone_number }}</td>
					<td>{{ $job->description }}</td>
					<td nowrap>{{ $job->last_operator_team }}</td>
					<td nowrap>{{ $job->last_operator_name() }}</td>
				</tr>
			@endforeach
			
		</tbody>
	</table>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Closed<small> - index</small></div>

                <div class="panel-body">
					@yield('table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

