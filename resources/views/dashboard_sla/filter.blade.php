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
<form class="form-inline" role="form" action="{{ url('/dashboard_sla') }}" method="get">
    <label><strong>ตัวกรอง</strong></label> -
    <!-- <div class="form-group">
        <input class="form-control" type="text" name="from" placeholder="From date" value="{{ Request::get('from') }}" onfocus="(this.type='date')" onblur="(this.type='text')" />
    </div>
    
    <div class="form-group">
        <input class="form-control" type="text" name="to" placeholder="To date" value="{{ Request::get('to') }}" onfocus="(this.type='date')" onblur="(this.type='text')" />
    </div> -->
    <div class="form-group">
        <select class="form-control" id="groupby" name="groupby">
            <option value="day" {{ old('groupby') == 'day' ? 'selected' : '' }}>รายวัน</option>
            <option value="week" {{ old('groupby') == 'week' ? 'selected' : '' }}>รายสัปดาห์</option>
            <option value="month" {{ old('groupby') == 'month' ? 'selected' : '' }}>รายเดือน</option>
            {{-- <option value="duration" {{ old('groupby') == 'duration' ? 'selected' : '' }}>ช่วงระยะเวลา</option> --}}
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
                {{-- <option value="{{ $week-$i }}" {{ old('week') == $week-$i ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. $year)[$week-$i] }}</option> --}}
                <option value="{{ $month-$i }}" {{ old('month') == $month-$i ? 'selected' : '' }}>
                    {{ Config::get('app.month_of_year')[$month-$i] }}
                </option>
            @endfor
            {{-- <option value="{{ date('n') }}" {{ old('month') == date('n') ? 'selected' : '' }}>{{ Config::get('app.month_of_year')[date('n')] }}</option> --}}
            {{-- <option value="{{ date('n')-1 }}" {{ old('month') == date('n')-1 ? 'selected' : '' }}>{{ Config::get('app.month_of_year')[date('n')-1] }}</option> --}}
            {{-- <option value="{{ date('n')-2 }}" {{ old('month') == date('n')-2 ? 'selected' : '' }}>{{ Config::get('app.month_of_year')[date('n')-2] }}</option> --}}
            {{-- <option value="{{ date('n')-3 }}" {{ old('month') == date('n')-3 ? 'selected' : '' }}>{{ Config::get('app.month_of_year')[date('n')-3] }}</option> --}}
        </select>
    </div>
    <div class="form-group">      
        <select class="form-control" id="week" name="week">
            {{-- <option value="{{ date('W') }}" {{ old('week') == date('W') ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')] }}</option> --}}
            <?php $year = date('Y'); $week = date('W'); ?>
            @for($i=0; $i<8; $i++)
                @if($week-$i == 0)
                    <?php $year = $year-1; $week = 52+$i; ?>
                @endif
                <option value="{{ $week-$i }}" {{ old('week') == $week-$i ? 'selected' : '' }}>
                    {{ Config::get('app.week_of_year_'. $year)[$week-$i] }}
                </option>
            @endfor
            {{-- <option value="{{ date('W')-2 }}" {{ old('week') == date('W')-2 ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')-2] }}</option>
            <option value="{{ date('W')-3 }}" {{ old('week') == date('W')-3 ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')-3] }}</option>
            <option value="{{ date('W')-4 }}" {{ old('week') == date('W')-4 ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')-4] }}</option>
            <option value="{{ date('W')-5 }}" {{ old('week') == date('W')-5 ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')-5] }}</option>
            <option value="{{ date('W')-6 }}" {{ old('week') == date('W')-6 ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')-6] }}</option>
            <option value="{{ date('W')-7 }}" {{ old('week') == date('W')-7 ? 'selected' : '' }}>{{ Config::get('app.week_of_year_'. date('Y'))[date('W')-7] }}</option> --}}
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
        <select class="form-control" id="call_category" name="call_category" style="width: 200px;">
            <option value="">All Call Category</option>
            @foreach ($call_categories as $call_category)
            <option value="{{ $call_category->id }}" {{ Request::get('call_category') == $call_category->id ? 'selected' : '' }}>{{ $call_category->problem_group }}</option>
            @endforeach
        </select>
	</div>
    <div class="form-group">
        <button type="submit" class="btn btn-default">Filter</button>
        <a href="{{ url('/dashboard_sla') }}" class="btn btn-default">Reset</a>
    </div>
</form>