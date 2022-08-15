<script>
    $(function() {
        $('#groupby').change(function(){
            if ($(this).val() == 'month') {
                $('#month').show().attr('disabled', false);

                if ($('#year').val() == '2016') {
                    $('#week-2016').hide().attr('disabled', true);
                }
            } else if($(this).val() == 'week') {
                $('#month').hide().attr('disabled', true);

                if ($('#year').val() == '2016') {
                    $('#week-2016').show().attr('disabled', false);
                }
            }
        }).change();
    });
</script>
<form class="form-inline" role="form" action="{{ url('/dashboard') }}" method="get">
    <label><strong>ตัวกรอง</strong></label> -
    <div class="form-group">
        <select class="form-control" id="groupby" name="groupby">
            <option value="week" {{ old('groupby') == 'week' ? 'selected' : '' }}>รายสัปดาห์</option>
            {{--<option value="month" {{ old('groupby') == 'month' ? 'selected' : '' }}>รายเดือน</option>--}}
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" id="year" name="year">
            <option value="2019" {{ old('year') == '2019' ? 'selected' : '' }}>2019</option>
            <option value="2020" {{ old('year') == '2020' ? 'selected' : '' }}>2020</option>
            <option value="2021" {{ old('year') == '2021' ? 'selected' : '' }}>2021</option>
            <option value="2022" {{ old('year') == '2022' ? 'selected' : '' }}>2022</option>
            <!-- <option value="2017" {{ old('year') == '2017' ? 'selected' : '' }}>2017</option> -->
            <!-- <option value="2016" {{ old('year') == '2016' ? 'selected' : '' }}>2016</option> -->
        </select>
    </div>
    <div class="form-group">
        <select class="form-control" id="month" name="month">
            <?php $year = date('Y'); $month = date('n'); ?>
            @for($i=0; $i<3; $i++)
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
        <select class="form-control" id="week-{{ date('Y') }}" name="week">
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