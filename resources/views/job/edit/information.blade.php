<script>
$(function() {
	$('#department').change(function() {
		$('.select_system').hide();
		$('.select_system_ph1').hide();
		$('.select_system_ph2').hide();
		$('.select_system_ph3').hide();
		$('.select_system_ph4').hide();
		
		var text = $("#department option:selected").text();
		
		if(text.indexOf("[DOL1]") > -1) {
			$('.select_system_ph1').show();
		} else if(text.indexOf("[DOL2]") > -1) {
			$('.select_system_ph2').show();
		} else if(text.indexOf("[DOL3]") > -1) {
			$('.select_system_ph3').show();
		} else if(text.indexOf("[DOL4]") > -1) {
			$('.select_system_ph4').show();
		} else {
			$('.select_system').show();
		}
	}).change().selectize();
	$('#call_category').selectize();
	$('#primary_system').selectize();
	$('#primary_system_ph1').selectize();
	$('#primary_system_ph2').selectize();
	$('#primary_system_ph3').selectize();
	$('#primary_system_ph4').selectize();
	$('#secondary_system').selectize();
	$('#secondary_system_ph1').selectize();
	$('#secondary_system_ph2').selectize();
	$('#secondary_system_ph3').selectize();
	$('#secondary_system_ph4').selectize();
});
</script>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Infomation</div>
		
		<div class="panel-body form-horizontal">
			<div class="form-group">
				<label class="col-md-4 control-label">หน่วยงาน</label>
				<div class="col-md-8">
					<select required class="form-control" id="department" name="department">
						<option value="">Require</option>
						@foreach ($departments as $department)
							<option value="{{ $department->id }}" {{ $job->department_id == $department->id ? 'selected' : '' }}>
								[DOL{{ $department->phase }}] {{ $department->name }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">ชื่อผู้แจ้ง</label>
				<div class="col-md-8">
					<input required class="form-control" id="informer_name" name="informer_name" type="text" value="{{ $job->informer_name }}" placeholder="Require"/>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">เบอร์โทร</label>
				<div class="col-md-8">
					<input required class="form-control" id="informer_phone_number" name="informer_phone_number" type="text" value="{{ $job->informer_phone_number }}" placeholder="Require"/>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">ประเภทผู้แจ้ง</label>
				<div class="col-md-8">
					<label class="radio-inline">
						<input required type="radio" id="informer_type_C" name="informer_type" value="C" {{ $job->informer_type == 'C' ? 'checked' : '' }} >ลูกค้า
					</label>
					<label class="radio-inline">
						<input required type="radio" id="informer_type_I" name="informer_type" value="I" {{ $job->informer_type == 'I' ? 'checked' : '' }} >ภายใน (บริษัท)
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Counter</label>
				<div class="col-md-8">
					<input class="form-control" id="counter" name="counter" type="text" value="{{ $job->counter }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Screen ID</label>
				<div class="col-md-8">
					<input class="form-control" id="screen_id" name="screen_id" type="text" value="{{ $job->screen_id }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Software Version</label>
				<div class="col-md-8">
					<input class="form-control" id="sw_version" name="sw_version" type="text" value="{{ $job->sw_version }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">รายละเอียดปัญหา</label>
				<div class="col-md-8">
					<textarea required class="form-control" id="description" name="description" placeholder="Require">{{ $job->description }}</textarea>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">กลุ่มปัญหา</label>
				<div class="col-md-8">
					<select required class="form-control" id="call_category" name="call_category">
						<option value="">Require</option>
						@foreach ($call_categories as $call_category)
							<option value="{{ $call_category->id }}" {{ $job->call_category_id == $call_category->id ? 'selected' : '' }}>
							[{{ $call_category->code }}] {{ $call_category->problem_group }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">ระบบงานหลัก</label>
				<div class="col-md-8">
					<div class="select_system">
						<select class="form-control" id="primary_system" name="primary_system">
							<option value=""></option>
						</select>
					</div>
					<div class="select_system_ph1">
						<select class="form-control" id="primary_system_ph1" name="primary_system_ph1">
							<option value=""></option>
							@foreach ($systems_ph1 as $system)
								<option value="{{ $system->id }}" {{ $job->primary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph2">
						<select class="form-control" id="primary_system_ph2" name="primary_system_ph2">
							<option value=""></option>
							@foreach ($systems_ph2 as $system)
								<option value="{{ $system->id }}" {{ $job->primary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph3">
						<select class="form-control" id="primary_system_ph3" name="primary_system_ph3">
							<option value=""></option>
							@foreach ($systems_ph3 as $system)
								<option value="{{ $system->id }}" {{ $job->primary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph4">
						<select class="form-control" id="primary_system_ph4" name="primary_system_ph4">
							<option value=""></option>
							@foreach ($systems_ph4 as $system)
								<option value="{{ $system->id }}" {{ $job->primary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">ระบบงานรอง</label>
				<div class="col-md-8">
					<div class="select_system">
						<select class="form-control" id="secondary_system" name="secondary_system">
							<option value=""></option>
						</select>
					</div>
					<div class="select_system_ph1">
						<select class="form-control" id="secondary_system_ph1" name="secondary_system_ph1">
							<option value=""></option>
							@foreach ($systems_ph1 as $system)
								<option value="{{ $system->id }}" {{ $job->secondary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph2">
						<select class="form-control" id="secondary_system_ph2" name="secondary_system_ph2">
							<option value=""></option>
							@foreach ($systems_ph2 as $system)
								<option value="{{ $system->id }}" {{ $job->secondary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph3">
						<select class="form-control" id="secondary_system_ph3" name="secondary_system_ph3">
							<option value=""></option>
							@foreach ($systems_ph3 as $system)
								<option value="{{ $system->id }}" {{ $job->secondary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph4">
						<select class="form-control" id="secondary_system_ph4" name="secondary_system_ph4">
							<option value=""></option>
							@foreach ($systems_ph4 as $system)
								<option value="{{ $system->id }}" {{ $job->secondary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Return Job</label>
				<div class="col-md-8">
					<label class="checkbox-inline">
						<input type="checkbox" id="return_job" name="return_job" {{ $job->return_job == true ? 'checked' : '' }} >&nbsp;
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">หมายเหตุ</label>
				<div class="col-md-8">
					<textarea class="form-control" id="remark" name="remark">{{ $job->remark }}</textarea>
				</div>
			</div>
		</div>
		
	</div>
</div>