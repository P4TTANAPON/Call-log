@extends('layouts.app')
@section('member_active')
active
@endsection

@section('table')
<div>
	<label><strong>Total : {{ $users->count() }} record</strong></label>
</div>

<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th style="text-align:center;" nowrap>ชื่อ-นามสกุล</th>
				<th style="text-align:center;" nowrap>E-Mail</th>
				<th style="text-align:center;" nowrap>เบอร์โทรศัพท์</th>
				<th style="text-align:center;" nowrap>Team</th>
				<th style="text-align:center;" nowrap>Code Name</th>
				<th style="text-align:center;" nowrap>สถานะ</th>
				<th style="text-align:center; width:150px;" nowrap></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $item)
			<tr>
				<td>{{ $item->name }}</td>
				<td>{{ $item->email }}</td>
				<td>{{ $item->phone_number }}</td>
				<td>{{ $item->team }}</td>
				<td>{{ $item->code_name }}</td>
				<td style="text-align: center;">{{ ($item->deleted_at != '' ? 'ยกเลิก' : 'ปกติ') }}</td>
				<td style="text-align:center; width:150px;">
					<a href="{{ url('/member/edit?id='.$item->id) }}"> แก้ไข </a> 
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
			<input class="form-control" type="text" name="name" placeholder="ชื่อ-นามสกุล" value="{{ Request::get('name') }}" />
		</div>

		<div class="form-group">
			<input class="form-control" type="text" name="email" placeholder="E-mail" value="{{ Request::get('email') }}" />
		</div>

		<div class="form-group">
			<select class="form-control" name="team">
				<option value="" {{ Request::get('team')=='all' ? 'selected' : '' }}>All Team</option>
				<option value="CC" {{ Request::get('team')=='CC' ? 'selected' : '' }}>CC</option>
				<option value="DOL" {{ Request::get('team')=='DOL' ? 'selected' : '' }}>DOL</option>
				<option value="SP" {{ Request::get('team')=='SP' ? 'selected' : '' }}>SP</option>
				<option value="SA" {{ Request::get('team')=='SA' ? 'selected' : '' }}>SA</option>
				<option value="NW" {{ Request::get('team')=='NW' ? 'selected' : '' }}>NW</option>
				<option value="ST" {{ Request::get('team')=='ST' ? 'selected' : '' }}>ST</option>
				<option value="SCS" {{ Request::get('team')=='SCS' ? 'selected' : '' }}>Vender</option>
				<option value="OBS" {{ Request::get('team')=='OBS' ? 'selected' : '' }}>OBS</option>
			</select>
		</div>

		<div style="margin-bottom:10px;">
			<div class="form-group">
				<input class="btn btn-default" type="submit" value="Search" />
				<a class="btn btn-default" href="{{ url('/member') }}">Reset</a>
			</div>
		</div>
</form>
@endsection

@section('content')
<script>
	$(function() {
		// $('#department').selectize();
		// $('#project').val('4');
		// $('#project').change();

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
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Menber<small> - index</small></div>

				<div class="panel-body">


					@include('layouts.btn_create', ['url' => '/member/register'])
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