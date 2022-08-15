<div class="panel panel-default">
	<div class="panel-heading">Verder</div>
	<div class="panel-body">
		
		@if($job->scs_solve_user_id)
			<div class="form-group">
				<label class="col-md-3 control-label">การดำเนินการแก้ไข</label>
				<div class="col-md-9">
					<textarea disabled class="form-control">{{ $job->scsjob ? $job->scsjob->action : '' }}</textarea>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">เวลาที่เริ่มแก้ไข</label>
				<div class="col-md-9">
					<input disabled class="form-control" type="datetime-local" value="{{ $job->scsjob ? ($job->scsjob->start_dtm ? date('Y-m-d\TH:i', strtotime($job->scsjob->start_dtm)) : '') : '' }}" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">เวลาที่แก้ไขเสร็จ</label>
				<div class="col-md-9">
					<input disabled class="form-control" type="datetime-local" value="{{ $job->scsjob ? ($job->scsjob->action_dtm ? date('Y-m-d\TH:i', strtotime($job->scsjob->action_dtm)) : '') : '' }}" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">ผู้ดำเนินการ</label>
				<div class="col-md-9">
					<input disabled class="form-control" type="text" value="{{ $job->scsjob ? $job->scsjob->operator_name : '' }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">สาเหตุ</label>
				<div class="col-md-9">
					<textarea disabled class="form-control">{{ $job->scsjob ? $job->scsjob->cause : '' }}</textarea>
				</div>
			</div>
			

			<div class="form-group">
				<label class="col-md-3 control-label">หมายเหตุ</label>
				<div class="col-md-9">
					<textarea disabled class="form-control">{{ $job->scsjob ? $job->scsjob->remark : '' }}</textarea>
				</div>
			</div>
		@endif
	</div>
</div>