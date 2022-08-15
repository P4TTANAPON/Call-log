<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Infomation</div>
		
		<div class="panel-body form-horizontal">
			<div class="form-group">
				<label class="col-md-4 control-label">หน่วยงาน</label>
				<div class="col-md-8">
					<select disabled class="form-control">
						@if($job->department)
							<option>{{ $job->department->name }}</option>
						@else
							<option></option>
						@endif
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">ชื่อผู้แจ้ง</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->informer_name }}"/>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">เบอร์โทร</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->informer_phone_number }}"/>
				</div>
			</div>
	       
            @if (Request::user()->team != 'DOL')
			<div class="form-group">
				<label class="col-md-4 control-label">ประเภทผู้แจ้ง</label>
				<div class="col-md-8">
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->informer_type == 'C' ? 'checked' : '' }} >ลูกค้า
					</label>
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->informer_type == 'I' ? 'checked' : '' }} >ภายใน (บริษัท)
					</label>
				</div>
			</div>
            @endif
			
			<div class="form-group">
				<label class="col-md-4 control-label">Counter</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->counter }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Screen ID</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->screen_id }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Software Version</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->sw_version }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">รายละเอียดปัญหา</label>
				<div class="col-md-8">
					<textarea disabled class="form-control">{{ $job->description }}</textarea>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">กลุ่มปัญหา</label>
				<div class="col-md-8">
					<select disabled class="form-control">
						@if($job->call_category)
							<option>{{ $job->call_category->problem_group }}</option>
						@else
							<option></option>
						@endif
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">ระบบงานหลัก</label>
				<div class="col-md-8">
					<select disabled class="form-control">
						@if($job->primary_system)
							<option>[{{ $job->primary_system->flag }}] {{ $job->primary_system->name }}</option>
						@else
							<option></option>
						@endif
					</select>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">ระบบงานรอง</label>
				<div class="col-md-8">
					<select disabled class="form-control">
						@if($job->secondary_system)
							<option>[{{ $job->secondary_system->flag }}] {{ $job->secondary_system->name }}</option>
						@else
							<option></option>
						@endif
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Return Job</label>
				<div class="col-md-8">
					<label class="checkbox-inline">
						<input disabled type="checkbox" {{ $job->return_job == true ? 'checked' : '' }} >&nbsp;
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">หมายเหตุ</label>
				<div class="col-md-8">
					<textarea disabled class="form-control">{{ $job->remark }}</textarea>
				</div>
			</div>
		</div>
		
	</div>
</div>