<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier3</div>
		
			<div class="panel-body form-horizontal">
			
				@if($job->tier3_solve_user)
					
					<div class="form-group">
						<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
						<div class="col-md-9">
							<textarea disabled class="form-control">{{ $job->tier3_solve_description }}</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">ผลการแก้ไข</label>
						<div class="col-md-9">
							<label class="radio-inline">
								<input disabled type="radio" {{ $job->tier3_solve_result == '1' ? 'checked' : '' }} >ได้
							</label>
							<label class="radio-inline">
								<input disabled type="radio" {{ $job->tier3_solve_result == '0' ? 'checked' : '' }} >ไม่ได้
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">ส่งต่อ</label>
						<div class="col-md-9">
							<label class="radio-inline">
								<input disabled type="radio" {{ $job->tier3_forward == 'SCS' ? 'checked' : '' }} >SCS
							</label>
						</div>
					</div>
				@endif

				@if($job->closed)
					@if($job->tier1_forward != 'SCS' and $job->tier2_forward != 'SCS' and $job->tier3_forward != 'SCS'
					and $job->tier1_forward != 'NW' and $job->tier2_forward != 'NW'
					and $job->tier1_forward != 'ST' and $job->tier2_forward != 'ST')
						@if(Request::user()->team == 'SA')
							<form class="form-horizontal" role="form" action="{{ url('/job/'.$job->id.'/review') }}" method="post">
								{{ csrf_field() }}
								{{ method_field('PATCH') }}

								@include('job.edit.sareview')

								<div class="form-group">
									<div class="col-md-9 col-md-offset-3">
										<button class="form-control btn btn-success" type="submit">บันทึก</button>
									</div>
								</div>
							</form>
						@else
							@include('job.show.sareview')
						@endif
					@endif
				@endif
				
			</div>
		
	</div>
</div>