@extends('layouts.app')

@section('table')
<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th nowrap>ID</th>
				<th nowrap>Product</th>
				<th nowrap>Model / Part Number</th>
				<th nowrap>Serial Number</th>
				<th nowrap>Install Location</th>
				<th nowrap>Note</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $item)
				<tr>
					<td>{{ $item->id }}</td>
					<td>{{ $item->product }}</td>
					<td>{{ $item->model_part_number }}</td>
					<td>{{ $item->serial_number }}</td>
					<td>{{ $item->install_location }}</td>
					<td>{{ $item->note }}</td>
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
                <div class="panel-heading">PH2 Hardware<small> - index</small></div>

                <div class="panel-body">
					@include('layouts.btn_import', ['url' => '/hw/ph2/import'])
					<hr/>
					@yield('table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

