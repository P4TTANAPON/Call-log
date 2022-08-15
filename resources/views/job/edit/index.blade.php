@extends('layouts.app')

@section('job_active')
    active
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><strong>Job<small> - edit</small></strong></div>
                    
                    <div class="panel-body">

                        @include('common.messages')
                        @include('common.errors')
                        
                        <a href="{{ url('/job') }}" class="btn btn-default"><span
                                    class="glyphicon glyphicon-th-large"></span> Index</a>

                        @if($canDelete)
                            <a href="{{ url('/job/'.$job->id.'/delete') }}" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Delete</a>
                        @elseif($canReject)
                            <a href="{{ url('/job/'.$job->id.'/reject') }}" class="btn btn-warning">
                                <span class="glyphicon glyphicon-remove-circle"></span> Reject</a>
                        @endif

                        @if (Request::user()->team == 'CC')
                            <a href="{{ url('/sat-survey/create?ticket='.$job->ticket_no) }}" class="btn btn-default" target="_blank">Survey</a>
                        @endif

                        <p>&nbsp;</p>

                        @include('job.show.systemInformation')

                        <form class="form-horizontal" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}

                            @if($job->tier1_forward == 'SCS' or $job->tier2_forward == 'SCS' or $job->tier3_forward == 'SCS' or $job->call_category_id == '5')
                                <div class="row">
                                    @if((Request::user()->team == 'CC' and !$job->scsjob)
                                    or (Request::user()->team == 'CC' and $job->scsjob and $job->active_operator_id == null))
                                        <div class="col-md-6">
                                            @include('job.edit.ccscs')
                                        </div>
                                        <div class="col-md-6">
                                            @include('job.show.scs')
                                        </div>
                                    @elseif((Request::user()->team == 'SCS' and Request::user()->id == $job->active_operator_id)
                                    or (Request::user()->team == 'SCS' and $job->closed == true and $job->confirm_closed == false))
                                        <div class="col-md-6">
                                            @include('job.show.ccscs')
                                        </div>
                                        <div class="col-md-6">
                                            @include('job.edit.scs')
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            @include('job.show.ccscs')
                                        </div>
                                        <div class="col-md-6">
                                            @include('job.show.scs')
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="row">
                            
                                @if(Request::user()->team == 'CC' or Request::user()->team == 'DOL')
                                    @if($job->tier2_forward == 'SCS' or $job->tier3_forward == 'SCS')
                                        @include('job.show.information')
                                        @include('job.show.tier1')
                                        @include('job.show.tier2')
                                        @include('job.show.tier3')
                                    @else
                                        @include('job.edit.information')
                                        @include('job.edit.tier1')
                                        @include('job.show.tier2')
                                        @include('job.show.tier3')
                                    @endif
                                @endif

                                @if(Request::user()->team == 'SP')
                                    @include('job.show.information')
                                    @include('job.show.tier1')
                                    @include('job.edit.tier2')
                                    @include('job.show.tier3')
                                @endif

                                @if(Request::user()->team == 'SA' or Request::user()->team == 'NW' or Request::user()->team == 'ST')
                                    @include('job.show.information')
                                    @include('job.show.tier1')
                                    @include('job.show.tier2')
                                    @include('job.edit.tier3')
                                @endif

                                @if(Request::user()->team == 'SCS')
                                    @include('job.show.information')
                                    @include('job.show.tier1')
                                    @include('job.show.tier2')
                                    @include('job.show.tier3')
                                @endif

                                @if(Request::user()->team == 'OBS' )
                                    @include('job.edit.information')
                                    @include('job.edit.tier1')
                                    @if ($job->tier1_forward == 'SP')
                                        @include('job.edit.tier2')
                                    @endif

                                    @if ($job->tier2_forward == 'SA')
                                        @include('job.edit.tier3')
                                    @endif
                                    
                                @endif

                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-4">
                                        <button class="form-control btn btn-success" type="submit">บันทึก</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        @include('job.survey')
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection