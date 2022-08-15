@extends('layouts.app')

@section('scs_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">SCS Job<small> - create</small></div>

                <div class="panel-body">
					@include('layouts.btn_index', ['url' => '/scs'])
					<hr/>
					@include('scs_job.form', ['action' => 'create'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection