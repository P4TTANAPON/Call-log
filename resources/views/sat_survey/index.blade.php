@extends('layouts.app')

@section('survey_active')
active
@endsection

@section('content')
<script>

</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Satisfaction Survey<small> - index</small></strong></div>

                <div class="panel-body">
					{{-- <p>UNDER CONSTRUCTION</p> --}}
                    {{-- <form action="">
                        <input type="text" class="form-control" placeholder="ค้นจาก Ticket No หรือ หมายเลข Job">
                    </form> --}}
                    
                    <a href="{{ url('/q') }}" class="btn btn-default" target="_blank"><span class="glyphicon glyphicon-file"></span> Create</a>
                    <hr>
                    {!! $surveyList->render() !!}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ticket No.</th>
                                    {{-- <th>วัน-เวลา</th> --}}
                                    {{-- <th>IP</th> --}}
                                    <th style="width: 150px">ความพึงพอใจ<br/>การแก้ไขปัญหา (1-5)</th>
                                    <th style="width: 150px">ระบบที่ใช้เป็นประจำ</th>
                                    <th style="width: 150px">ความพึงพอใจ<br/>ระบบงาน (1-10)</th>
                                    <th>ความคิดเห็นเพิ่มเติม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surveyList as $survey)
                                    <tr>
                                        <td><a href="{{ url('/job/'.$survey->job_id) }}">{{ $survey->ticket_no }}</a></td>
                                        {{-- <td style="width:96px">{{ $survey->created_at }}</td> --}}
                                        {{-- <td>{{ $survey->visitor }}<br/>( {{ $survey->created_user }} )</td> --}}
                                        <td>{!! $survey->getSurveyIcon() !!}</td>
                                        <td>{{ $survey->q2 }}</td>
                                        <td>{{ $survey->q3 }}</td>
                                        <td>{{ $survey->q4 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $surveyList->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

