@extends('layouts.app')

@section('scs_active')
active
@endsection

@section('table')
<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th nowrap>Ticket No.</th>
				<th nowrap>วัน-เวลา</th>
				<th nowrap>หมายเลขอุปกรณ์</th>
				<th nowrap>อุปกรณ์</th>
				<th nowrap>รุ่นอุปกรณ์</th>
				<th nowrap>อาการขัดข้องของอุปกรณ์ที่พบ</th>
				<th nowrap>สาเหตุ</th>
				<th nowrap>การดำเนินการแก้ไข</th>
				<th nowrap>หมายเหตุ</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($scs_jobs as $scs_job)
				<tr>
					<td><a href="{{ url('/scs/' . $scs_job->id) }}">{{ $scs_job->job->ticket_no }}</a></td>
					<td>{{ $scs_job->created_at }}</td>
					<td>{{ $scs_job->serial_number }}</td>
					<td>{{ $scs_job->product }}</td>
					<td>{{ $scs_job->model_part_number }}</td>
					<td>{{ $scs_job->malfunction }}</td>
					<td>{{ $scs_job->cause }}</td>
					<td>{{ $scs_job->action }}</td>
					<td>{{ $scs_job->remark }}</td>
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
                <div class="panel-heading">SCS Job<small> - index</small></div>

                <div class="panel-body">
					@yield('table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

