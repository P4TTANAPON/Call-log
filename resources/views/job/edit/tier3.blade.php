<script>
$(function() {
	$('#tier3_solve_result_1').change(function() {
        if($(this).is(":checked")) {
            $('input[name="tier3_forward"]').prop('checked', false).prop('disabled', true);
        } 
    }).dblclick(function() {
		if($(this).is(":checked")) {
			$(this).prop('checked', false);
			$('input[name="tier3_forward"]').prop('checked', false);
		}
	});
	
	$('#tier3_solve_result_0').change(function() {
        if($(this).is(":checked")) {
            $('#tier3_forward_SCS').prop('checked', true).prop('disabled', false);
        }
    }).dblclick(function() {
		if($(this).is(":checked")) {
			$(this).prop('checked', false);
			$('input[name="tier3_forward"]').prop('checked', false);
		}
	});
});
</script>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier3</div>
		
		<div class="panel-body form-horizontal">
			
			<div class="form-group">
				<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
				<div class="col-md-9">
					<textarea required class="form-control" id="tier3_solve_description" name="tier3_solve_description">{{ $job->tier3_solve_description }}</textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">ผลการแก้ไข</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier3_solve_result_1" name="tier3_solve_result" value="1" {{ $job->tier3_solve_result == '1' ? 'checked' : '' }} >ได้
					</label>
					<label class="radio-inline">
						<input type="radio" id="tier3_solve_result_0" name="tier3_solve_result" value="0" {{ $job->tier3_solve_result == '0' ? 'checked' : '' }} >ไม่ได้
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">ส่งต่อ</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier3_forward_SCS" name="tier3_forward" value="SCS" {{ $job->tier3_forward == 'SCS' ? 'checked' : '' }} >SCS
					</label>
				</div>
			</div>
			
			@if(($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
			and ($job->active_operator_team != 'NW' and $job->last_operator_team != 'NW')
			and ($job->active_operator_team != 'ST' and $job->last_operator_team != 'ST'))
				@if(Request::user()->team == 'SA' or Request::user()->team == 'OBS') <!-- ROOT -->
					@include('job.edit.sareview')
				@else
					@include('job.show.sareview')
				@endif
			@endif
		</div>
		
	</div>
</div>