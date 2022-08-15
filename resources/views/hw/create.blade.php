@extends('layouts.app')

@section('detail')
<form class="form-inline" role="form" action="{{ url('/hw') }}" method="post">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Infomation</div>
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="row">
					<div>
						<label class="col-md-3 control-label">สำนักงานที่ดิน</label>
						<div class="col-md-9">
							<select required class="form-control" id="department" name="department" style="width: 450px;">
								<option value="">All Departments</option>
								@foreach ($departments as $department)
								<option value="{{ $department->departments }}" {{ Request::get('department') == $department->departments ? 'selected' : '' }}>{{ $department->departments }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<br />
					<div>
						<label class="col-md-3 control-label">Product</label>
						<div class="col-md-9">
							<select required class="form-control" id="product" name="product" style="width: 450px;">
								<option value="">All Product</option>
								@foreach ($products as $product)
								<option value="{{ $product->product }}" {{ Request::get('product') == $product->product ? 'selected' : '' }}>{{ $product->product }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label">Model / Part Number</label>
						<div class="col-md-9">
							<select required class="form-control" id="model_part_number" name="model_part_number" style="width: 450px;">
								<option value="">All Model / Part Number</option>
								@foreach ($model_part_numbers as $model_part_number)
								<option value="{{ $model_part_number->model_part_number }}" {{ Request::get('model_part_number') == $model_part_number->model_part_number ? 'selected' : '' }}>{{ $model_part_number->model_part_number }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label">Serial Number</label>
						<div class="col-md-9">
							<input required class="form-control" type="text" name="serial_number" placeholder="Serial Number" value="{{ Request::get('serial_number') }}" />
						</div>
					</div>
					<br />
					<div>
						<label class="col-md-3 control-label">เลขครุภัณฑ์</label>
						<div class="col-md-9">
							<input class="form-control" type="text" name="inventory_no" placeholder="เลขครุภัณฑ์" value="{{ Request::get('inventory_no') }}" />
						</div>
					</div>	
					<br />
					<div class="col-md-9" style="text-align:center;">
						<button class="form-control btn btn-success" type="submit">
							บันทึก
						</button>
					</div>

				</div>

			</div>

		</div>

	</div>
</form>
@endsection

@section('content')
<script>
	$(function() {
		$('#department').selectize();
		$('#product').selectize();
		$('#model_part_number').selectize();
		//$('#project').change();
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

					@include('layouts.btn_import', ['url' => '/hw/import'])
					@include('layouts.btn_create', ['url' => '/hw/create'])
					<hr />
					@yield('detail')

				</div>
			</div>
		</div>
	</div>
</div>
@endsection