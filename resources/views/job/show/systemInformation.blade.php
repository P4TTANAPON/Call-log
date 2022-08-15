<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">System Infomation</div>
			
			<div class="panel-body">
				<div class="col-md-6">
					<dl class="dl-horizontal">
						<dt>Ticket No</dt>
						<dd>{{ $job->ticket_no }}</dd>
						<dt>Created at</dt>
						<dd>{{ $job->created_at }}</dd>
						
						@if($job->tier1_solve_result == false)
							<dt>Call Center</dt>
							<dd>{{ $job->create_user->name }}</dd>
							<dt>Phone Number</dt>
							<dd>{{ $job->create_user->phone_number }}</dd>
						@endif
						
						@if($job->tier2_solve_result_dtm)
							@if($job->tier2_solve_user and $job->tier2_solve_result == false)
								<dt>Support</dt>
								<dd>{{ $job->tier2_solve_user->name }}</dd>
								<dt>Phone Number</dt>
								<dd>{{ $job->tier2_solve_user->phone_number }}</dd>
							@endif
						@endif
					</dl>
				</div>
				<div class="col-md-6">
					<dl class="dl-horizontal">
						@if($job->closed)
							<dt>Status</dt>
							<dd>Closed</dd>
							<dt>Closed at</dt>
							<dd>{{ $job->closed_at }}</dd>
							<dt>Last Operator</dt>
							<dd>{{ $job->last_operator_name() }} [{{ $job->last_operator_team }}]</dd>
							<dt>Phone Number</dt>
							<dd>{{ $job->last_operator_phone_number() }}</dd>
						@else
							<dt>Active Operator</dt>
							<dd>{{ $job->active_operator_name() }} [{{ $job->active_operator_team == 'SCS' ? 'Vender' : $job->active_operator_team }}]</dd>
							<dt>Phone Number</dt>
							<dd>{{ $job->active_operator_phone_number() }}</dd>
						@endif
						
						@if($job->sa_rw)
							<dt>Review</dt>
							<dd>{{ $job->sa_rw_name() }}</dd>
							<dt>Phone Number</dt>
							<dd>{{ $job->sa_rw_phone_number() }}</dd>
						@endif
					</dl>
				</div>
			</div>
			
		</div>
	</div>
</div>