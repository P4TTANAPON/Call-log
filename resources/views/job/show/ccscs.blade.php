<div class="panel panel-default">
	<div class="panel-heading">Hardware</div>
	<div class="panel-body">
		
		@if($job->scsjob)
			<div class="form-group">
				<label class="col-md-4 control-label">หมายเลขอุปกรณ์</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->scsjob ? $job->scsjob->serial_number : '' }}" placeholder="Require"/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-4"></div>
				<div class="col-md-8">
					<div id="hw_search_result"></div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">อุปกรณ์ที่ขัดข้อง</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->scsjob ? $job->scsjob->product : '' }}"  placeholder="Require"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">รุ่นอุปกรณ์</label>
				<div class="col-md-8">
					<input disabled class="form-control" type="text" value="{{ $job->scsjob ? $job->scsjob->model_part_number : '' }}"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Ticket</label>
				<div class="col-md-8">
					<textarea disabled class="form-control">{{ $job->scsjob ? $job->scsjob->malfunction : '' }}</textarea>
				</div>
			</div>
		@endif
	</div>
</div>