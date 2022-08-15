<script>
$(function() {
	$('#tier1_solve_result_1').change(function() {
        if($(this).is(":checked")) {
            $('input[name="tier1_forward"]').prop('checked', false).prop('disabled', true);
        } 
    });
	
	$('#tier1_solve_result_0').change(function() {
        if($(this).is(":checked")) {
            $('#tier1_forward_SP').prop('checked', true).prop('disabled', false);
        }
    });
});
</script>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier1</div>
		
		<div class="panel-body form-horizontal">
			<div class="form-group">
				<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
				<div class="col-md-9">
					<textarea class="form-control" id="tier1_solve_description" name="tier1_solve_description">{{ $job->tier1_solve_description }}</textarea>
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-md-3 control-label">ผลการแก้ไข</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier1_solve_result_1" name="tier1_solve_result" value="1" {{ $job->tier1_solve_result == '1' ? 'checked' : '' }} >ได้
					</label>
					<label class="radio-inline">
						<input type="radio" id="tier1_solve_result_0" name="tier1_solve_result" value="0" {{ $job->tier1_solve_result == '0' ? 'checked' : '' }} >ไม่ได้
					</label>
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-md-3 control-label">ส่งต่อ</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier1_forward_SP" name="tier1_forward" value="SP" {{ $job->tier1_forward == 'SP' ? 'checked' : '' }} >Support
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="SA" {{ $job->tier1_forward == 'SA' ? 'checked' : '' }} >SA
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="NW" {{ $job->tier1_forward == 'NW' ? 'checked' : '' }} >Network
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="ST" {{ $job->tier1_forward == 'ST' ? 'checked' : '' }} >System
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="SCS" {{ $job->tier1_forward == 'SCS' ? 'checked' : '' }} >Vender
					</label>
				</div>
			</div>
		</div>
		
	</div>
</div>