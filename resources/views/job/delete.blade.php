@extends('layouts.app')

@section('job_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Job<small> - delete</small></strong></div>

                <div class="panel-body">
					<a class="btn btn-default" href="{{ url('/job/'.$job->id) }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
					
					<p>&nbsp;</p>
					
					<p class="text-danger">Confirm delete?<p>
					
					@include('job.show.systemInformation')
					
					<form action="{{ url('/job/'.$job->id) }}" method="post">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<button type="submit" id="delete-job-{{ $job->id }}" class="btn btn-danger">Delete</button>
					</form>
					
                </div>
				
            </div>
        </div>
    </div>
</div>
@endsection