@extends('layouts.app')

@section('job_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Job<small> - reject</small></strong></div>

                <div class="panel-body">
					<a class="btn btn-default" href="{{ url('/job/'.$job->id.'/edit') }}"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
					
					<p>&nbsp;</p>
					
					<p class="text-warning">Confirm reject?<p>
					
					@include('job.show.systemInformation')
					
					<form action="{{ url('/job/'.$job->id.'/reject') }}" method="post">
						{{ csrf_field() }}
						{{ method_field('PATCH') }}
						
						<button type="submit" id="reject-job-{{ $job->id }}" class="btn btn-warning">Reject</button>
					</form>
					
                </div>
				
            </div>
        </div>
    </div>
</div>
@endsection