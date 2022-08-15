@if ($job->survey()->count())
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Satisfaction Survey</div>
                <div class="panel-body">
                    @foreach ($job->survey()->get() as $survey)
                        <div class="col-md-6">
                            <div class="panel panel-default">
                            
                                <div class="panel-body">
                                    <div class="pull-right">
                                        {!! $survey->getSurveyIcon() !!}
                                    </div>
                                    <dl>
                                        <dt>Created at</dt>
                                        <dd>{{ $survey->created_at }}</dd>
                                        <dt>IP</dt>
                                        <dd>{{ $survey->visitor }} ( {{ $survey->created_user }} )</dd>
                                        <dt>1. คุณให้คะแนนความพึงพอใจในการแก้ไขปัญหานี้กี่คะแนน</dt>
                                        <dd>- {{ $survey->q1_text }}</dd>
                                        <dt>2. คุณใช้ระบบอะไรเป็นประจำ</dt>
                                        <dd>- {{ $survey->q2 }}</dd>
                                        <dt>3. คุณให้คะแนนความพึงพอใจในระบบที่คุณใช้งานกี่คะแนน โดยที่ 10 เป็นคะแนนที่มากที่สุด และ 1 เป็นคะแนนที่น้อยที่สุด</dt>
                                        <dd>- {{ $survey->q3 }}</dd>
                                        <dt>4. คุณมีความคิดเห็นอย่างไรกับระบบงานนี้ สิ่งที่ดี/สิ่งที่ต้องการปรับปรุง/สิ่งที่ต้องเพิ่มเติม)</dt>
                                        <dd>- {{ $survey->q4 }}</dd>
                                    </dl>   
                                </div>
                            
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif