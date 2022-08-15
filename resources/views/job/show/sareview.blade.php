<div class="form-group">
	<label class="col-md-3 control-label">Review</label>
	<div class="col-md-9">
		<label class="checkbox-inline">
			<input disabled type="checkbox" {{ $job->sa_rw == true ? 'checked' : '' }} >&nbsp;
		</label>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">กลุ่มปัญหา</label>
	<div class="col-md-9">
		<select disabled class="form-control">
			@if($job->sa_rw_call_category)
				<option>{{ $job->sa_rw_call_category->problem_group }}</option>
			@else
				<option></option>
			@endif
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">ระบบงานหลัก</label>
	<div class="col-md-9">
		<select disabled class="form-control">
			@if($job->sa_rw_primary_system)
				<option>{{ $job->sa_rw_primary_system->name }}</option>
			@else
				<option></option>
			@endif
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">ระบบงานรอง</label>
	<div class="col-md-9">
		<select disabled class="form-control">
			@if($job->sa_rw_secondary_system)
				<option>{{ $job->sa_rw_secondary_system->name }}</option>
			@else
				<option></option>
			@endif
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">Return Job</label>
	<div class="col-md-9">
		<label class="checkbox-inline">
			<input disabled type="checkbox" {{ $job->sa_rw_return_job == true ? 'checked' : '' }} >&nbsp;
		</label>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label">หมายเหตุ</label>
	<div class="col-md-9">
		<textarea disabled class="form-control">{{ $job->sa_rw_remark }}</textarea>
	</div>
</div>