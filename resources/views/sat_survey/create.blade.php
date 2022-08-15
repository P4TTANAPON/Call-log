@extends('layouts.app')

@section('survey_active')
active
@endsection

@section('content')
<script>

</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Satisfaction Survey<small> - create</small></strong></div>

                <div class="panel-body">
					@if($errors->any())
                        <div class="alert alert-warning">
                            <strong>Warning!</strong> {{ $errors->first() }}
                        </div>
                    @endif
                    <form action="{{ url('/sat-survey') }}" method="post">
                        {{ csrf_field() }}
                        <p>คำถามสำหรับประเมินความพึงพอใจในการให้บริการและความพึงพอใจในระบบงานสารสนเทศที่ดินที่บริษัทพัฒนาในโครงการพัฒนาระบบสารสนเทศที่ดิน ระยะที่ 1</p>
                        <input type="text" class="form-control" name="ticket_or_job" value="{{ $ticketNo?:old('ticket_or_job') }}" placeholder="Ticket No / Job Number">
                        <br>
                        <p>1. คุณให้คะแนนความพึงพอใจในการแก้ไขปัญหานี้กี่คะแนน</p>
                        <div class="radio">
                            <label><input type="radio" name="q1" value="1" {{ old('q1')=='1'?'checked':'' }} required>ปรับปรุง</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q1" value="2" {{ old('q1')=='2'?'checked':'' }} required>พอใช้</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q1" value="3" {{ old('q1')=='3'?'checked':'' }} required>ดี</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q1" value="4" {{ old('q1')=='4'?'checked':'' }} required>ดีมาก</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q1" value="5" {{ old('q1')=='5'?'checked':'' }} required>ดีเยี่ยม</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <br>
                        <p>2. คุณใช้ระบบอะไรเป็นประจำ</p>
                        <input type="text" class="form-control" name="q2" value="{{ old('q2') }}" required>
                        <br>
                        <p>3. คุณให้คะแนนความพึงพอใจในระบบที่คุณใช้งานกี่คะแนน โดยที่ 10 เป็นคะแนนที่มากที่สุด และ 1 เป็นคะแนนที่น้อยที่สุด</p>
                        <div class="radio">
                            <label><input type="radio" name="q3" value="1" {{ old('q3')=='1'?'checked':'' }} required>1</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="2" {{ old('q3')=='2'?'checked':'' }} required>2</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="3" {{ old('q3')=='3'?'checked':'' }} required>3</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="4" {{ old('q3')=='4'?'checked':'' }} required>4</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="5" {{ old('q3')=='5'?'checked':'' }} required>5</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="6" {{ old('q3')=='6'?'checked':'' }} required>6</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="7" {{ old('q3')=='7'?'checked':'' }} required>7</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="8" {{ old('q3')=='8'?'checked':'' }} required>8</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="9" {{ old('q3')=='9'?'checked':'' }} required>9</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type="radio" name="q3" value="10" {{ old('q3')=='10'?'checked':'' }} required>10</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <br>
                        <p>4. คุณมีความคิดเห็นอย่างไรกับระบบงานนี้ สิ่งที่ดี/สิ่งที่ต้องการปรับปรุง/สิ่งที่ต้องเพิ่มเติม)</p>
                        <textarea class="form-control" row="2" name="q4">{{ old('q4') }}</textarea>
                        <br>
                        <input type="submit" class="form-control btn btn-success" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

