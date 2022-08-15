<script>
	$(function() {
		$('#sa_rw').change(function() {
			if($(this).is(":checked")) {
				disableSelectize('#sa_rw_call_category', false);
				disableSelectize('#sa_rw_primary_system', false);
				disableSelectize('#sa_rw_secondary_system', false);
				$('#sa_rw_return_job').prop('disabled', false);
				$('#sa_rw_remark').prop('disabled', false);
			} else {
				disableSelectize('#sa_rw_call_category', true);
				disableSelectize('#sa_rw_primary_system', true);
				disableSelectize('#sa_rw_secondary_system', true);
				$('#sa_rw_return_job').prop('checked', false).prop('disabled', true);
				$('#sa_rw_remark').val('').prop('disabled', true);
			}
		}).change();

		$('#sa_rw_call_category').selectize();
		$('#sa_rw_primary_system').selectize();
		$('#sa_rw_secondary_system').selectize();

		function disableSelectize(id, disabled) {
			var select = $(id).selectize();
			var selectize = select[0].selectize;

			if(disabled) {
				selectize.clear();
				selectize.disable();
			} else {
				selectize.enable();
			}
		}
	});
</script>
<div class="form-group">
	<label class="col-md-3 control-label">Review</label>
	<div class="col-md-9">
		<label class="checkbox-inline">
			<input type="checkbox" id="sa_rw" name="sa_rw" value="1" {{ $job->sa_rw == '1' ? 'checked' : '' }} >&nbsp;
		</label>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">กลุ่มปัญหา</label>
	<div class="col-md-9">
		<select class="form-control" id="sa_rw_call_category" name="sa_rw_call_category">
			<option value=""></option>
			@foreach($call_categories as $call_category)
				@if($call_category->id == $job->call_category_id)
					@continue
				@endif
				<option value="{{ $call_category->id }}" {{ $call_category->id == $job->sa_rw_call_category_id ? 'selected' : '' }}>{{ $call_category->problem_group }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">ระบบงานหลัก</label>
	<div class="col-md-9">
		<select class="form-control" id="sa_rw_primary_system" name="sa_rw_primary_system">
			<option value=""></option>
			@foreach ($systems as $system)
				@if($system->id == $job->primary_system_id)
					@continue
				@endif
				<option value="{{ $system->id }}" {{ $system->id == $job->sa_rw_primary_system_id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">ระบบงานรอง</label>
	<div class="col-md-9">
		<select class="form-control" id="sa_rw_secondary_system" name="sa_rw_secondary_system">
			<option value=""></option>
			@foreach ($systems as $system)
				@if($system->id == $job->secondary_system_id)
					@continue
				@endif
				<option value="{{ $system->id }}" {{ $system->id == $job->sa_rw_secondary_system_id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">Return Job</label>
	<div class="col-md-9">
		<label class="checkbox-inline">
			<input type="checkbox" id="sa_rw_return_job" name="sa_rw_return_job" value="1" {{ $job->sa_rw_return_job == '1' ? 'checked' : '' }} >&nbsp;
		</label>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">หมายเหตุ</label>
	<div class="col-md-9">
		<textarea class="form-control" id="sa_rw_remark" name="sa_rw_remark">{{ $job->sa_rw_remark }}</textarea>
	</div>
</div>