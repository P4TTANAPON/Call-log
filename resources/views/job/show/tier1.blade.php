<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier1</div>
		
		<div class="panel-body form-horizontal">
			<div class="form-group">
				<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
				<div class="col-md-9">
					<textarea disabled class="form-control">{{ $job->tier1_solve_description }}</textarea>
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-md-3 control-label">ผลการแก้ไข</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_solve_result == true ? 'checked' : '' }} >ได้
					</label>
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_solve_result == false ? 'checked' : '' }} >ไม่ได้
					</label>
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-md-3 control-label">ส่งต่อ</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_forward == 'SP' ? 'checked' : '' }} >Support
					</label>
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_forward == 'SA' ? 'checked' : '' }} >SA
					</label>
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_forward == 'NW' ? 'checked' : '' }} >Network
					</label>
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_forward == 'ST' ? 'checked' : '' }} >System
					</label>
					<label class="radio-inline">
						<input disabled type="radio" {{ $job->tier1_forward == 'SCS' ? 'checked' : '' }} >Vender
					</label>
				</div>
			</div>
		</div>
		
	</div>
</div>