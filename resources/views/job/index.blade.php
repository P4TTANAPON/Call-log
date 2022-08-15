@extends('layouts.app')

@section('job_active')
active
@endsection

@section('table')
<div>
	<label><strong>Total : {{ $jobs->total() }} record</strong></label>
</div>
{!! $jobs->appends([
'from' => Request::get('from'),
'to' => Request::get('to'),
'job' => Request::get('job'),
'team' => Request::get('team'),
'active_user' => Request::get('active_user'),
'ticket' => Request::get('ticket'),
'project' => Request::get('project'),
'system' => Request::get('system'),
'department' => Request::get('department'),
'call_category' => Request::get('call_category'),
'informer_name' => Request::get('informer_name'),
'informer_phone_number' => Request::get('informer_phone_number'),
'description' => Request::get('description'),
])->render() !!}
<div class="table-responsive">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th nowrap style="width: 108px;">Ticket No.</th>
				<th nowrap>วัน-เวลา</th>
				<th nowrap>หน่วยงาน</th>
				<th nowrap>ชื่อผู้แจ้ง</th>
				<th nowrap>รายละเอียดปัญหา</th>
				<th nowrap>ผู้ดูแล</th>
				<th nowrap style="width: 52px;">Status</th>
				<th nowrap style="width: 47px;">Review</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($jobs as $job)
				
				@if((Request::user()->team == $job->active_operator_team and $job->active_operator_id == null)
				or ((Request::user()->team == 'OBS' or Request::user()->team == 'CC' or Request::user()->team == 'DOL') and $job->closed == true and $job->cc_confirm_closed == false))
					<tr class="info">
				@else
					<tr>
				@endif
				
					<td nowrap>
						<a href="{{ url('/job/'.$job->id) }}">{{ $job->ticket_no }}</a>
						@if($job->isSla())
							<?php $progress = $job->progress(); ?>
							<div class="progress" style="margin-bottom: 5px">
								<div class="progress-bar
								{{ $progress['p'] >= 100 ? 'progress-bar-danger' : ''}}
								{{ $progress['p'] >= 70 && $progress['p'] < 100 ? 'progress-bar-warning' : 'progress-bar-success' }}
								{{ $job->closed ? '' : 'progress-bar-striped active'}}"
									 role="progressbar" style="width: {{ $progress['p'] }}%">
									{{ $progress['p'] > 30 && $progress['p'] < 100 ? $progress['h'] : ($progress['p'] >= 100 ? 'Over SLA' : '') }}
								</div>
							</div>
						@endif
						@if ($job->survey()->count())
							<div>
								{!! $job->getSurveyIcon() !!}
							</div>
						@endif
					</td>
					<td nowrap style="width:86px">{{ $job->created_at }}</td>
					<td nowrap><?php echo str_replace(' ', "<br/>", $job->department->name) ?></td>
					<td style="width:100px">{{ $job->informer_name }}<br/>{{ $job->informer_phone_number }}</td>
					<td>
						@if($job->sa_rw_primary_system_id)
							{{ '[' . $job->sa_rw_primary_system->flag . '] ' }}
							@if($job->sa_rw_secondary_system_id)
								{{ '[' . $job->sa_rw_secondary_system->flag . '] ' }}
							@endif
						@elseif($job->primary_system_id)
							{{ '[' . $job->primary_system->flag . '] ' }}
							@if($job->secondary_system_id)
								{{ '[' . $job->secondary_system->flag . '] ' }}
							@endif
						@endif
						@if($job->scsjob)
							{{ $job->scsjob->product }}
							<br/>
							{{ $job->scsjob->model_part_number }}
							<br/>
							{{ ' S/N: ' . $job->scsjob->serial_number }}
							<br/>
						@endif
						{{ $job->description }}
						@if($job->scsjob)
							<br/>
							{{ 'Ticket : ' . $job->scsjob->malfunction }}
						@endif
					</td>
					<td nowrap>
						@if($job->closed)
							[{{ $job->last_operator_team == 'SCS' ? 'Vender' : $job->last_operator_team }}] {{ $job->last_operator_name() }}
						@else
							[{{ $job->active_operator_team == 'SCS' ? 'Vender' : $job->active_operator_team }}] {{ $job->active_operator_name() }}
						@endif
					</td>
					<td nowrap>
						@if($job->closed == true and $job->cc_confirm_closed == true)
							<span class="label label-success">Closed</span> 
						@elseif($job->closed == true and $job->cc_confirm_closed == false)
							<span class="label label-info">Confirm</span> 
						@else
							<span class="label label-primary">Active</span> 
						@endif
					</td>
					<td nowrap>
						@if($job->sa_rw)
							<span class="glyphicon glyphicon-ok" style="color: green"></span>
						@endif
					</td>
				</tr>
			@endforeach
			
		</tbody>
	</table>
</div>
<!-- &project=&system=&department=&call_category=10&informer_name=&informer_phone_number=&description= -->
{!! $jobs->appends([
'from' => Request::get('from'),
'to' => Request::get('to'),
'job' => Request::get('job'),
'team' => Request::get('team'),
'ticket' => Request::get('ticket'),
'project' => Request::get('project'),
'system' => Request::get('system'),
'department' => Request::get('department'),
'call_category' => Request::get('call_category'),
'informer_name' => Request::get('informer_name'),
'informer_phone_number' => Request::get('informer_phone_number'),
'description' => Request::get('description'),
])->render() !!}
@endsection

@section('filter')
<form class="form-inline" role="form" action="" method="get">
	<div style="margin-bottom:10px;">
		<label><strong>Filter</strong></label>
	</div>
	
	<div style="margin-bottom:10px;">
		<div class="form-group">
			<input class="form-control" type="text" name="from" placeholder="From date" value="{{ Request::get('from') }}" onfocus="(this.type='date')" onblur="(this.type='text')" />
		</div>
		
		<div class="form-group">
			<input class="form-control" type="text" name="to" placeholder="To date" value="{{ Request::get('to') }}" onfocus="(this.type='date')" onblur="(this.type='text')" />
		</div>
		
		<div class="form-group">
			<select class="form-control" name="job">
				<option value="active" {{ Request::get('job')=='active' ? 'selected' : '' }}>Active</option>
				<option value="closed" {{ Request::get('job')=='closed' ? 'selected' : '' }}>Closed</option>
				<option value="all" {{ Request::get('job')=='all' ? 'selected' : '' }}>All</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="team" onchange="loadTeam(this); ">
				<option value="" {{ Request::get('team')=='all' ? 'selected' : '' }}>All Team</option>
				<option value="cc-sp-sa" {{ Request::get('team')=='cc-sp-sa' ? 'selected' : '' }}>CC-SP-SA</option>
				<option value="cc" {{ Request::get('team')=='cc' ? 'selected' : '' }}>CC</option>
				<option value="sp" {{ Request::get('team')=='sp' ? 'selected' : '' }}>SP</option>
				<option value="sa" {{ Request::get('team')=='sa' ? 'selected' : '' }}>SA</option>
				<option value="nw" {{ Request::get('team')=='nw' ? 'selected' : '' }}>NW</option>
				<option value="st" {{ Request::get('team')=='st' ? 'selected' : '' }}>ST</option>
				<option value="scs" {{ Request::get('team')=='scs' ? 'selected' : '' }}>Vender</option>
			</select>
		</div>
		
		<div class="form-group">
			<select class="form-control" id="active_user" name="active_user" style="width: 200px;">
				<option value="">All User</option>
				@foreach ($users as $user)
				<option value="{{ $user->id }}" {{ Request::get('active_user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<input class="form-control" type="text" name="ticket" placeholder="Ticket No" value="{{ Request::get('ticket') }}"/> 
		</div>
	</div>
	
	<div style="margin-bottom:10px;">
		<div class="form-group">
			<select class="form-control" id="project" name="project" style="width: 150px;" onchange="loadSystem(this); loadDepartment(this)">
				<option value="">All Project</option>
				<option value="1" {{ Request::get('project') == '1' ? 'selected' : '' }}>DOL 1</option>
				<option value="2" {{ Request::get('project') == '2' ? 'selected' : '' }}>DOL 2</option>
				{{--<option value="3">DOL 3</option>--}}
				<option value="4" {{ Request::get('project') == '4' ? 'selected' : '' }}>DOL 4 </option>
			</select>
		</div>
		
		<div class="form-group">
			<select class="form-control" id="system" name="system" style="width: 150px;">
				<option value="">All System</option>
			</select>
		</div>
		
		<div class="form-group">
			<select class="form-control" id="department" name="department" style="width: 300px;">
				<option value="">All Department</option>
				@foreach ($departments as $department)
				<option value="{{ $department->id }}" {{ Request::get('department') == $department->id ? 'selected' : '' }}>[DOL{{ $department->phase }}] {{ $department->name }}</option>
				@endforeach
			</select>
		</div>
		
		<div class="form-group">
			<select class="form-control" id="call_category" name="call_category" style="width: 200px;">
				<option value="">All Call Category</option>
				@foreach ($call_categories as $call_category)
				<option value="{{ $call_category->id }}" {{ Request::get('call_category') == $call_category->id ? 'selected' : '' }}>{{ $call_category->problem_group }}</option>
				@endforeach
			</select>
		</div>
		
	</div>
	
	<div style="margin-bottom:10px;">
		<div class="form-group">
			<input class="form-control" type="text" name="informer_name" placeholder="ชื่อผู้แจ้ง" value="{{ Request::get('informer_name') }}"/> 
		</div>
		<div class="form-group">
			<input class="form-control" type="text" name="informer_phone_number" placeholder="เบอร์โทร" value="{{ Request::get('informer_phone_number') }}"/> 
		</div>
		<div class="form-group">
			<input class="form-control" type="text" name="description" placeholder="Description" value="{{ Request::get('description') }}" style="width: 300px;"/> 
		</div>
	</div>
	
	<div style="margin-bottom:10px;">
		<div class="form-group">
			<input class="btn btn-default" type="submit" value="Search" />
			<a class="btn btn-default" href="{{ url('/job') }}">Reset</a>
		</div>
	</div>
</form>
@endsection

@section('content')
<script>
	$(function() {
		$('#department').selectize();
		$('#active_user').selectize();
		$('#project').change();
	});

	function loadSystem(e)
	{
		$.ajax({
			method: 'GET',
			url: '{{ url("/system/getdropdown") }}',
			data: { 'phase': $(e).val(), 'system': '{{ Request::get("system") }}' },
			cache: false
		}).done(function( html ) {
			$('#system').html( html )
		});
	}

	function loadDepartment(e)
	{
		$.ajax({
			method: 'GET',
			url: '{{ url("/department/getdropdown") }}',
			data: { 'phase': $(e).val(), 'department': '{{ Request::get("department") }}' },
			cache: false
		}).done(function( html ) {
			$('#department').selectize()[0].selectize.destroy();
			$('#department').html( html );
			$('#department').selectize();
		});
	}

	function loadTeam(e)
	{
		$.ajax({
			method: 'GET',
			url: '{{ url("/user/getdropdown") }}',
			data: { 'team': $(e).val() },
			cache: false
		}).done(function( html ) {
			
			$('#active_user').selectize()[0].selectize.destroy();
			$('#active_user').html( html );
			$('#active_user').selectize();
		});
	}
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
			@include('layouts.warning_almost')
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Job<small> - index</small></strong></div>

                <div class="panel-body">
					
					@include('common.messages')
				
					@if(Request::user()->team == 'CC' or Request::user()->team == 'DOL' or Request::user()->team == 'OBS')
						@include('layouts.btn_create', ['url' => '/job/create'])
						<hr/>
					@endif
					
                    @if(Request::user()->team != 'DOL')
					   <a href="{{ url('/job/export') }}{{ empty(explode('?', $_SERVER['REQUEST_URI'])[1]) ? '' : '?'.explode('?', $_SERVER['REQUEST_URI'])[1] }}" class="btn btn-link pull-right">
						  <span class="glyphicon glyphicon-export"></span> Export</a>
					@endif

					@yield('filter')
					<hr/>

					@yield('table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

