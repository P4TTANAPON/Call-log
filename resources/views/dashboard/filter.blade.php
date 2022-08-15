<script>
    $(function() {
        $('#groupby').change(function(){
            if ($(this).val() == 'month') {
                $('#month').show().attr('disabled', false);
                $('#week').hide().attr('disabled', true);
                $('#date-from').hide().attr('disabled', true);
                $('#year').show().attr('disabled', false);
                $('#date-to').hide().attr('disabled', true);
            } else if($(this).val() == 'week') {
                $('#week').show().attr('disabled', false);
                $('#month').hide().attr('disabled', true);
                $('#date-from').hide().attr('disabled', true);
                $('#year').show().attr('disabled', false);
                $('#date-to').hide().attr('disabled', true);
            } else if($(this).val() == 'day'){
                $('#week').hide().attr('disabled', true);
                $('#month').hide().attr('disabled', true);
                $('#date-from').show().attr('disabled', false);
                $('#year').hide().attr('disabled', true);
                $('#date-to').hide().attr('disabled', true);

            } else if($(this).val()== 'duration'){
                $('#week').hide().attr('disabled', true);
                $('#month').hide().attr('disabled', true);
                $('#date-from').show().attr('disabled', false);
                $('#year').hide().attr('disabled', true);
                $('#date-to').show().attr('disabled', false);
            }
        }).change();
    });
</script>
<form class="form-inline" role="form" action="{{ url('/dashboard') }}" method="get">
    <label><strong>ตัวกรอง</strong></label> -
    <div class="form-group">
        <select class="form-control" id="groupby" name="groupby">
            <option value="day" {{ old('groupby') == 'day' ? 'selected' : '' }}>รายวัน</option>
            <option value="week" {{ old('groupby') == 'week' ? 'selected' : '' }}>รายสัปดาห์</option>
            <option value="month" {{ old('groupby') == 'month' ? 'selected' : '' }}>รายเดือน</option>
            <option value="duration" {{ old('groupby') == 'duration' ? 'selected' : '' }}>ช่วงระยะเวลา</option>
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" id="year" name="year">
            {{$year = date('Y')}}
            @for ($i=2019; $i<$year+1; $i++)
                <option value="{{$i}}" {{ old('year') == $i ? 'selected' : '' }}>{{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" id="month" name="month">
            <?php $year = date('Y'); $month = date('n'); ?>
            @for($i=0; $i<5; $i++)
                @if($month-$i == 0)
                    <?php $year = $year-1; $month = 12+$i; ?>
                @endif
                <option value="{{ $month-$i }}" {{ old('month') == $month-$i ? 'selected' : '' }}>
                    {{ Config::get('app.month_of_year')[$month-$i] }}
                </option>
            @endfor
        </select>
    </div>
    <div class="form-group">      
        <select class="form-control" id="week" name="week">
            <?php $year = date('Y'); $week = date('W'); ?>
            @for($i=0; $i<8; $i++)
                @if($week-$i == 0)
                    <?php $year = $year-1; $week = 52+$i; ?>
                @endif
                <option value="{{ $week-$i }}" {{ old('week') == $week-$i ? 'selected' : '' }}>
                    {{ Config::get('app.week_of_year_'. $year)[$week-$i] }}
                </option>
            @endfor
        </select>
    </div>
    <div class="form-group" id="date-from">
        {{-- <label for="from">ตั้งแต่</label> --}}
        <input class="form-control" type="text" id="from" name="fromDate" placeholder="From date" value="{{ old('fromDate', date('Y-m-d')) }}" onfocus="(this.type='date')" onblur="(this.type='text')" />
    </div>
    
    <div class="form-group" id="date-to">
        {{-- <label for="from">ถึง</label> --}}
        <input class="form-control" type="text" id="to" name="toDate" placeholder="To date" value="{{ old('toDate', date('Y-m-d')) }}" onfocus="(this.type='date')" onblur="(this.type='text')" />
    </div>
    <div class="form-group">
        <select class="form-control" id="project" name="project">
            <option value="all" {{ old('project') == 'all' ? 'selected' : '' }}>ทุกโครงการ</option>
            <option value="dol1" {{ old('project') == 'dol1' ? 'selected' : '' }}>DOL 1</option>
            <option value="dol2" {{ old('project') == 'dol2' ? 'selected' : '' }}>DOL 2</option>
            <option value="dol4" {{ old('project') == 'dol4' ? 'selected' : '' }}>DOL 4</option>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-default">Filter</button>
        <a href="{{ url('/dashboard') }}" class="btn btn-default">Reset</a>
    </div>
</form>