@extends('layouts.app')

@section('hw_active')
active
@endsection

@section('detail')
<form class="form-inline" role="form" action="{{ url('/hw') }}" method="post">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Hardware<small> - edit</small></div>
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="row">
					<div>
						<label class="col-md-3 control-label">id</label>
						<div class="col-md-9">
							{{ $items->id }}
						</div>
					</div>
					<div>
						<label class="col-md-3 control-label">สำนักงานที่ดิน</label>
						<div class="col-md-9">
							{{ $items->departments }}
						</div>
					</div>

					<br />
					<div>
						<label class="col-md-3 control-label">Product</label>
						<div class="col-md-9">
							{{ $items->product }}
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label">Model / Part Number</label>
						<div class="col-md-9">
							{{ $items->model_part_number }}
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label">Serial Number</label>
						<div class="col-md-9">
							{{ $items->serial_number }}
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label">เลขครุภัณฑ์</label>
						<div class="col-md-9">
							{{ $items->inventory_no }}
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label"></label>
						<div class="col-md-9">

						</div>
					</div>


				</div>

			</div>

		</div>

	</div>
</form>
@endsection

@section('table')
<div>
	<label><strong>รายการแจ้งซ่อมทั้งหมด : {{ $hisItems->count() }} record</strong></label>
</div>
<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th style="text-align:center; width:150px;" nowrap>SLA</th>
				<th style="text-align:center;" nowrap>วันที่แจ้งซ่อม</th>
				<th style="text-align:center;" nowrap>ปัญหาที่ได้รับแจ้ง</th>
				<th style="text-align:center;" nowrap>วันที่เข้าดำเนินการซ่อม</th>
				<th style="text-align:center;" nowrap>วันที่ซ่อมเสร็จ</th>
				<th style="text-align:center;" nowrap>สาเหตุ</th>
				<th style="text-align:center;" nowrap>วิธีการแก้ไข</th>
				<th style="text-align:center; width:150px;" nowrap>สถานะ</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($hisItems as $hisitem)
			<tr>
				<td style="text-align:center; width:150px;">
					{{ $hisitem->job->ticket_no }}
					<b>
						Ticket No : {{ $hisitem->malfunction }}
					</b>
					@if($hisitem->job)
					<?php $progress = $hisitem->job->progress(); ?>
					<div class="progress" style="margin-bottom: 5px">
						<div class="progress-bar
								{{ $progress['p'] >= 100 ? 'progress-bar-danger' : ''}}
								{{ $progress['p'] >= 70 && $progress['p'] < 100 ? 'progress-bar-warning' : 'progress-bar-success' }}
								{{ $hisitem->job->closed ? '' : 'progress-bar-striped active'}}" role="progressbar" style="width: {{ $progress['p'] }}%">
							{{ $progress['p'] > 30 && $progress['p'] < 100 ? $progress['h'] : ($progress['p'] >= 100 ? 'Over SLA' : '') }}
						</div>
					</div>

					@endif
				</td>
				<td>{{ $hisitem->job->created_at }}</td>
				<td>
					@if($hisitem->job)
					{{ $hisitem->job->description }}
					@endif
				</td>
				<td>{{ $hisitem->start_dtm }}</td>
				<td>{{ $hisitem->action_dtm }}</td>
				<td>{{ $hisitem->cause }}</td>
				<td>{{ $hisitem->action }}</td>
				<td style="text-align:center; width:150px;">
					@if($hisitem->job)
					@if($hisitem->job->closed == true and $hisitem->job->cc_confirm_closed == true)
					<span class="label label-success">Closed</span>
					@elseif($hisitem->job->closed == true and $hisitem->job->cc_confirm_closed == false)
					<span class="label label-info">Confirm</span>
					@else
					<span class="label label-primary">Active</span>
					@endif
					@endif
				</td>
			</tr>
			@endforeach

		</tbody>
	</table>
</div>
@endsection

@section('content')
<script>
	function loadDepartment(e) {
		if ($(e).val() != '') {
			$.ajax({
				method: 'GET',
				url: '{{ url("/department/getHWDepartment") }}',
				data: {
					'phase': $(e).val()
				},
				cache: false
			}).done(function(html) {
				$('#department').selectize()[0].selectize.destroy();
				$('#department').html(html);
				$('#department').selectize();
			});
		}

	}
</script>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Hardware Create<small> - index</small></div>

				<div class="panel-body">
					@include('common.messages')
					@include('common.errors')
					<div style="text-align:left;">
						<a href="{{ url('/hw?serial_number='.$items->serial_number) }}" class="btn btn-link">ย้อนกลับ</a>
					</div>
					<hr />
					@yield('detail')
					<hr />
					@yield('table')
					<hr />

				</div>
			</div>
		</div>
	</div>
</div>
@endsection