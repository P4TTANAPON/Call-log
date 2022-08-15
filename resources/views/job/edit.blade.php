@extends('layouts.app')

@section('job_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Job<small> - edit</small></div>

                <div class="panel-body">
					@include('layouts.btn_index', ['url' => '/job'])&nbsp;
					
					@if($job->active_operator_team==Request::user()->team and $job->active_operator_id=='')
						
						@if(Request::user()->team == 'SCS')
							@if($job->active_operator_team == 'SCS' and $job->scsjob == true)
								<form style="display:inline-block;" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
									{!! csrf_field() !!}
									<input name="_method" type="hidden" value="patch"/>
									<input name="_action" type="hidden" value="accept"/>
									<input class="btn btn-primary" type="submit" value="Accept"/>
								</form>
							@endif
						@else
							<form style="display:inline-block;" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
								{!! csrf_field() !!}
								<input name="_method" type="hidden" value="patch"/>
								<input name="_action" type="hidden" value="accept"/>
								<input class="btn btn-primary" type="submit" value="Accept"/>
							</form>
						@endif
					
					@endif
					
					@if(Request::user()->team == 'CC')
					
						@if($job->active_operator_team=='SCS' and $job->active_operator_id==null)
						{{--<a href="{{ url('/scs/create/'.$job->id) }}" class="btn btn-default">Send SCS</a>--}}
						<form style="display:inline-block;" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
							{!! csrf_field() !!}
							<input name="_method" type="hidden" value="patch"/>
							<input name="_action" type="hidden" value="reject_scs"/>
							{{--<input class="btn btn-default" type="submit" value="Reject"/>--}}
						</form>
						@endif
						
						@if($job->active_operator_team=='SCS' and $job->active_operator_id!=null)
						<form style="display:inline-block;" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
							{!! csrf_field() !!}
							<input name="_method" type="hidden" value="patch"/>
							<input name="_action" type="hidden" value="close_job_scs"/>
							{{--<input class="btn btn-default" type="submit" value="Close Job"/>--}}
						</form>
						@endif
					
					@endif
					
					@if(Request::user()->team == 'ROOT')
						@include('layouts.btn_delete', ['url' => '/job', 'controller' => 'job', 'id' => $job->id])
					@endif
					<hr/>
					@include('job.form', ['action' => 'edit'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection