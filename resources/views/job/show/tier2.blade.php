<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier2</div>
		
		<div class="panel-body form-horizontal">
		
			@if($job->tier2_solve_user)
			
				<div class="form-group">
					<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
					<div class="col-md-9">
						<textarea disabled class="form-control">{{ $job->tier2_solve_description }}</textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">ผลการแก้ไข</label>
					<div class="col-md-9">
						<label class="radio-inline">
							<input disabled type="radio" {{ $job->tier2_solve_result == '1' ? 'checked' : '' }} >ได้
						</label>
						<label class="radio-inline">
							<input disabled type="radio" {{ $job->tier2_solve_result == '0' ? 'checked' : '' }} >ไม่ได้
						</label>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">ส่งต่อ</label>
					<div class="col-md-9">
						<label class="radio-inline">
							<input disabled type="radio" {{ $job->tier2_forward == 'SA' ? 'checked' : '' }} >SA
						</label>
						<label class="radio-inline">
							<input disabled type="radio" {{ $job->tier2_forward == 'NW' ? 'checked' : '' }} >Network
						</label>
						<label class="radio-inline">
							<input disabled type="radio" {{ $job->tier2_forward == 'ST' ? 'checked' : '' }} >System
						</label>
						<label class="radio-inline">
							<input disabled type="radio" {{ $job->tier2_forward == 'SCS' ? 'checked' : '' }} >Verder
						</label>
					</div>
				</div>
				
			@endif
			
		</div>
		
	</div>
</div>