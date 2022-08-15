@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">PH2 Hardware<small> - import</small></div>

                <div class="panel-body">
					@include('layouts.btn_index', ['url' => '/hw/ph2'])
					<hr/>
					@include('layouts.messages')
					@include('layouts.errors')
					
					<form role="form" action="/hw/ph2/import" method="post" enctype="multipart/form-data" class="form-inline">
						{!! csrf_field() !!}
						<div class="form-group">
							<label for="file_import">Select file to import : </label>
							<input type="file" name="file_import" id="file_import" accept=".xls,.xlsx" class="form-control"/>
						</div>
						<input type="submit" value="Submit" name="submit" class="form-control"/>
					</form>
					
                </div>
            </div>
        </div>
    </div>
</div>
@endsection