@extends('layouts.app')

@section('job_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Job<small> - show</small></strong></div>

                <div class="panel-body">
				
					@include('common.messages')
					@include('common.errors')
					
					<a href="{{ url('/job') }}" class="btn btn-default"><span class="glyphicon glyphicon-th-large"></span> Index</a>
					
					@if (Request::user()->team == 'CC')
						<a href="{{ url('/sat-survey/create?ticket='.$job->ticket_no) }}" class="btn btn-default" target="_blank">Survey</a>
					@endif

					@if((Request::user()->team == 'CC' or Request::user()->team == 'DOL') and $job->closed == true and $job->cc_confirm_closed == false)
						<form style="display: inline;" action="{{ url('/job/'.$job->id.'/confirm-close') }}" method="post">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<button type="submit" id="confirm-close-job-{{ $job->id }}" class="btn btn-success"><span class="glyphicon glyphicon-ok-circle"></span> Confirm Close</button>
						</form>
					@endif
					
					@if(Request::user()->team == $job->active_operator_team and $job->active_operator_id == null)
						<form style="display: inline;" action="{{ url('/job/'.$job->id.'/accept') }}" method="post">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<button type="submit" id="accept-job-{{ $job->id }}" class="btn btn-primary">Accept</button>
						</form>
					@endif
					
					<p>&nbsp;</p>
					
					@include('job.show.systemInformation')
					
					@if($job->tier1_forward == 'SCS' or $job->tier2_forward == 'SCS' or $job->tier3_forward == 'SCS' or $job->call_category_id == '5')
						<div class="row form-horizontal">
							<div class="col-md-6">
								@include('job.show.ccscs')
							</div>
							<div class="col-md-6">
								@include('job.show.scs')
							</div>
						</div>
					@endif
					
					<div class="row">
						@include('job.show.information')
						@include('job.show.tier1')
						@include('job.show.tier2')
						@include('job.show.tier3')
					</div>
					
					@include('job.survey')

                </div>
				
            </div>
        </div>
    </div>
</div>
@endsection