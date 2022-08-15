@extends('layouts.app')

@section('table')
<div>
	<label><strong>Total : {{ $items->count() }} record</strong></label>
</div>
<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th style="text-align:center;" nowrap>Product</th>
				<th style="text-align:center;" nowrap>Model / Part Number</th>
				<th style="text-align:center;" nowrap>เลขครุภัณฑ์</th>
				<th style="text-align:center;" nowrap>Serial Number</th>
				<th style="text-align:center;" nowrap>Install Location</th>
				<th style="text-align:center;" nowrap>Note</th>
				<th style="text-align:center;" nowrap>สถานะ</th>
				<th style="text-align:center; width:150px;" nowrap></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $item)
			
			<tr>
				<td>{{ $item->product }}</td>
				<td>{{ $item->model_part_number }}</td>
				<td>{{ $item->inventory_no }}</td>
				<td>{{ $item->serial_number }}</td>
				<td>{{ $item->departments }}</td>
				<td>{{ $item->note }}</td>
				<td style="text-align:center; width:150px;">
					{{ $item-> hw_status() }}
					</br>
					{{ $item-> job_count() == 0 ? '' : 'แจ้งซ่อม ('. $item-> job_count() . ') ครั้ง' }}
				</td>
				<td style="text-align:center; width:150px;">
					<a href="{{ url('/hw/edit?id='.$item->id) }}"> แก้ไข </a> |
					<a href="{{ url('/hw/show?id='.$item->id) }}"> รายละเอียด </a>
				</td>
			</tr>
			@endforeach

		</tbody>
	</table>
</div>
@endsection

@section('filter')
<form class="form-inline" role="form" action="" method="get">
	<div style="margin-bottom:10px;">
		<label><strong>Filter</strong></label>
	</div>

	<div style="margin-bottom:10px;">
		<div class="form-group">
			<select class="form-control" id="project" name="project" style="width: 150px;" onchange=" loadDepartment(this)">
				<option value="">All Project</option>
				<option value="1" {{ Request::get('project') == '1' ? 'selected' : '' }}>DOL 1</option>
				<option value="2" {{ Request::get('project') == '2' ? 'selected' : '' }}>DOL 2</option>
				{{--<option value="3">DOL 3</option>--}}
				<option value="4" {{ Request::get('project') == '4' ? 'selected' : '' }}>DOL 4 </option>
			</select>
		</div>

		<div class="form-group">
			<select class="form-control" id="department" name="department" style="width: 450px;">
				<option value="">All Department</option>
				<!-- @foreach ($departments as $department)
				<option value="{{ $department->id }}" {{ Request::get('department') == $department->id ? 'selected' : '' }}>[DOL{{ $department->phase }}] {{ $department->name }}</option>
				@endforeach -->
			</select>
		</div>

		<div class="form-group">
			<select class="form-control" id="model_part_number" name="model_part_number" style="width: 200px;">
				<option value="">All Call Category</option>
				@foreach ($products as $product)
				<option value="{{ $product->model_part_number }}" {{ Request::get('model_part_number') == $product->model_part_number ? 'selected' : '' }}>{{ $product->model_part_number }}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<select class="form-control" id="hw_status" name="hw_status" style="width: 150px;">
				<option value=""  {{ Request::get('hw_status') == '' ? 'selected' : '' }}>ทั้งหมด</option>
				<option value="1" {{ Request::get('hw_status') == '1' ? 'selected' : '' }}>ซ่อมเรียบร้อย</option>
				<option value="2" {{ Request::get('hw_status') == '2' ? 'selected' : '' }}>อยู่ระหว่างซ่อม</option>
			</select>
		</div>

	</div>

	<div style="margin-bottom:10px;">
		<div class="form-group">
			<input class="form-control" type="text" name="serial_number" placeholder="serial number" value="{{ Request::get('serial_number') }}" />
		</div>
	</div>

	<div style="margin-bottom:10px;">
		<div class="form-group">
			<input class="btn btn-default" type="submit" value="Search" />
			<a class="btn btn-default" href="{{ url('/hw') }}">Reset</a>
		</div>
	</div>
</form>
@endsection

@section('content')
<script>
	$(function() {
		$('#department').selectize();
		$('#project').val('4');
		$('#project').change();

	});

	// function loadSystem(e)
	// {
	// 	$.ajax({
	// 		method: 'GET',
	// 		url: '{{ url("/system/getdropdown") }}',
	// 		data: { 'phase': $(e).val(), 'system': '{{ Request::get("system") }}' },
	// 		cache: false
	// 	}).done(function( html ) {
	// 		$('#system').html( html )
	// 	});
	// }

	function loadDepartment(e) {
		if ($(e).val() != '') {
			$.ajax({
				method: 'GET',
				url: '{{ url("/department/getHWdropdown") }}',
				data: {
					'phase': $(e).val(),
					'department': '{{ Request::get("department") }}'
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
				<div class="panel-heading">Hardware<small> - index</small></div>

				<div class="panel-body">

					@include('common.messages')
					@include('common.errors')

					@include('layouts.btn_import', ['url' => '/hw/import'])
					@include('layouts.btn_create', ['url' => '/hw/create'])
					<hr />
					@yield('filter')
					<hr />
					@yield('table')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection