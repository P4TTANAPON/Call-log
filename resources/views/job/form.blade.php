<script>
$(function() {
	
	$('#department').change(function() {
		$('.primary_system').hide();
		$('.primary_system_ph1').hide();
		$('.primary_system_ph2').hide();
		$('.primary_system_ph3').hide();
		$('.primary_system_ph4').hide();
		
		$('.secondary_system').hide();
		$('.secondary_system_ph1').hide();
		$('.secondary_system_ph2').hide();
		$('.secondary_system_ph3').hide();
		$('.secondary_system_ph4').hide();
		
		$('.sa_rw_primary_system').hide();
		$('.sa_rw_primary_system_ph1').hide();
		$('.sa_rw_primary_system_ph2').hide();
		$('.sa_rw_primary_system_ph3').hide();
		$('.sa_rw_primary_system_ph4').hide();
		
		$('.sa_rw_secondary_system').hide();
		$('.sa_rw_secondary_system_ph1').hide();
		$('.sa_rw_secondary_system_ph2').hide();
		$('.sa_rw_secondary_system_ph3').hide();
		$('.sa_rw_secondary_system_ph4').hide();
		
		var text = $("#department option:selected").text();
		
		if(text.startsWith("[DOL1]")) {
			$('.primary_system_ph1').show();
			$('.secondary_system_ph1').show();
			
			@if($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
				$('.sa_rw_primary_system_ph1').show();
				$('.sa_rw_secondary_system_ph1').show();
			@endif
			
		} else if(text.startsWith("[DOL2]")) {
			$('.primary_system_ph2').show();
			$('.secondary_system_ph2').show();
			
			@if($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
				$('.sa_rw_primary_system_ph2').show();
				$('.sa_rw_secondary_system_ph2').show();
			@endif
			
		} else if(text.startsWith("[DOL3]")) {
			$('.primary_system_ph3').show();
			$('.secondary_system_ph3').show();
			
			@if($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
				$('.sa_rw_primary_system_ph3').show();
				$('.sa_rw_secondary_system_ph3').show();
			@endif
			
		} else if(text.startsWith("[DOL4]")) {
			$('.primary_system_ph4').show();
			$('.secondary_system_ph4').show();
			
			@if($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
				$('.sa_rw_primary_system_ph4').show();
				$('.sa_rw_secondary_system_ph4').show();
			@endif
			
		} else {
			$('.primary_system').show();
			$('.secondary_system').show();
			
			@if($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
				$('.sa_rw_primary_system').show();
				$('.sa_rw_secondary_system').show();
			@endif
			
		}
	}).change();
	
	$('#tier1_solve_result_1').click(function() {
		$('input[name="tier1_forward"]').prop('required', false);
		$('#tier1_solve_description').prop('required', true);
		$('#tier1_solve_description').prop('placeholder', 'Require');
		$('input[name="tier1_forward"]').prop('checked', false);
		$('input[name="tier1_forward"]').prop('disabled', true);
	});
	
	$('#tier1_solve_result_0').click(function() {
		$('input[name="tier1_forward"]').prop('required', true);
		$('#tier1_solve_description').prop('required', false);
		$('#tier1_solve_description').prop('placeholder', '');
		$('#tier1_forward_SP').prop('checked', true);
		$('input[name="tier1_forward"]').prop('disabled', false);
	});
	
	$('#tier2_solve_result_1').click(function() {
		$('input[name="tier2_forward"]').prop('required', false);
		$('#tier2_solve_description').prop('required', true);
		$('input[name="tier2_forward').prop('checked', false);
		$('input[name="tier2_forward').prop('disabled', true);
	});
	
	$('#tier2_solve_result_0').click(function() {
		$('input[name="tier2_forward"]').prop('required', true);
		$('#tier2_solve_description').prop('required', true);
		$('#tier2_forward_SA').prop('checked', true);
		$('input[name="tier2_forward').prop('disabled', false);
	});
	
	$('#tier3_solve_result_1').click(function() {
		$('input[name="tier3_forward"]').prop('required', false);
		$('#tier3_solve_description').prop('required', true);
		$('input[name="tier3_forward"]').prop('checked', false);
		$('#tier3_forward_SCS').prop('disabled', true);
	});
	
	$('#tier3_solve_result_0').click(function() {
		//$('input[name="tier3_forward"]').prop('required', true);
		$('#tier3_solve_description').prop('required', true);
		//$('#tier3_forward_SCS').prop('checked', true);
		$('#tier3_forward_SCS').prop('disabled', false);
	});
	
	@if(Request::user()->team == 'CC')
		
		var baseReadonly = false;
	
		@if((Request::user()->id == $job->last_operator_id and $job->active_operator_id == null) or $job->id==null)
			var baseReadonly2 = false;	
			var tier1Readonly = false;
			
		@else
			var baseReadonly = true;	
			var baseReadonly2 = true;	
			var tier1Readonly = true;
			
		@endif
		
		var tier2Readonly = true;
		var tier3Readonly = true;
		
		@if($job->scsjob)
			@if((Request::user()->id == $job->last_operator_id and $job->active_operator_id == null))
				var hardwareReadonly = false;
			@else
				var hardwareReadonly = true;
			@endif
		@else
			var hardwareReadonly = false;
		@endif
		
		var scsReadonly = true;
	@elseif(Request::user()->team == 'SP')
		
		var baseReadonly = true;
		var tier1Readonly = true;
		var tier3Readonly = true;
		
		@if(Request::user()->id == $job->active_operator_id 
		or (Request::user()->id == $job->last_operator_id and $job->active_operator_id == null))
			var baseReadonly2 = false;
			var tier2Readonly = false;
			
			$('input[name="tier2_solve_result"]').prop('required', true);
			//$('input[name="tier2_forward"]').prop('required', true);
			
		@else
			var baseReadonly2 = true;
			var tier2Readonly = true;
		@endif
		
	@elseif((Request::user()->team == 'SA' 
		or Request::user()->team == 'NW'
		or Request::user()->team == 'ST') 
		and (Request::user()->id == $job->active_operator_id
		or Request::user()->id == $job->last_operator_id and $job->cc_confirm_closed == false))
		
		var baseReadonly = true;
		var baseReadonly2 = true;
		var tier1Readonly = true;
		var tier2Readonly = true;
		var tier3Readonly = false;
		
		//$('input[name="tier3_solve_result"]').prop('required', true);
		//$('input[name="tier3_forward"]').prop('required', true);
		
	@elseif(Request::user()->team == 'SCS')
		
		@if(Request::user()->id == $job->active_operator_id 
			or (Request::user()->id == $job->last_operator_id and $job->active_operator_id == null))
			var scsReadonly = false;
		@else
			var scsReadonly = true;
		@endif
		
		var hardwareReadonly = true;
		var baseReadonly = true;
		var baseReadonly2 = true;
		var tier1Readonly = true;
		var tier2Readonly = true;
		var tier3Readonly = true;
	@elseif(Request::user()->team == 'OBS')
		var baseReadonly = false;
		var baseReadonly2 = false;
		var tier1Readonly = false;
		var tier2Readonly = false;
		var tier3Readonly = false;
		
		@if(Request::user()->team == 'SP' or Request::user()->team == 'SA' 
		or Request::user()->team == 'NW' or Request::user()->team == 'ST')
			var scsReadonly = true;
			var hardwareReadonly = true;
		@endif
	@else
		
		var baseReadonly = true;
		var baseReadonly2 = true;
		var tier1Readonly = true;
		var tier2Readonly = true;
		var tier3Readonly = true;
		
		@if(Request::user()->team == 'SP' or Request::user()->team == 'SA' 
		or Request::user()->team == 'NW' or Request::user()->team == 'ST')
			var scsReadonly = true;
			var hardwareReadonly = true;
		@endif
	@endif
	
	@if($job->closed and $job->cc_confirm_closed)
		scsReadonly = true;
		baseReadonly = true;
		baseReadonly2 = true;
		tier1Readonly = true;
		tier2Readonly = true;
		tier3Readonly = true;
	@endif
	
	if(baseReadonly) {
		$('#department').prop('disabled', true);
		$('#informer_name').prop('disabled', true);
		$('#informer_phone_number').prop('disabled', true);
		$('input[name="informer_type"]').prop('disabled', true);
		$('#sw_version').prop('disabled', true);
		$('#description').prop('disabled', true);
		$('#counter').prop('disabled', true);
		$('#screen_id').prop('disabled', true);
	} else {
		$('#department').selectize();
	}
	
	if(baseReadonly2) {
		$('#call_category').prop('disabled', true);
		$('#primary_system').prop('disabled', true);
		$('#primary_system_ph1').prop('disabled', true);
		$('#primary_system_ph2').prop('disabled', true);
		$('#primary_system_ph3').prop('disabled', true);
		$('#primary_system_ph4').prop('disabled', true);
		$('#secondary_system').prop('disabled', true);
		$('#secondary_system_ph1').prop('disabled', true);
		$('#secondary_system_ph2').prop('disabled', true);
		$('#secondary_system_ph3').prop('disabled', true);
		$('#secondary_system_ph4').prop('disabled', true);
		$('#remark').prop('disabled', true);
		$('#return_job').prop('disabled', true);
	} else {
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
		
	}
	
	@if(Request::user()->team == 'SA' and $job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
		$('#sa_rw_call_category').selectize();
		$('#sa_rw_primary_system').selectize();
		$('#sa_rw_primary_system_ph1').selectize();
		$('#sa_rw_primary_system_ph2').selectize();
		$('#sa_rw_primary_system_ph3').selectize();
		$('#sa_rw_primary_system_ph4').selectize();
		$('#sa_rw_secondary_system').selectize();
		$('#sa_rw_secondary_system_ph1').selectize();
		$('#sa_rw_secondary_system_ph2').selectize();
		$('#sa_rw_secondary_system_ph3').selectize();
		$('#sa_rw_secondary_system_ph4').selectize();
	@endif
	
	if(tier1Readonly) {
		$('#tier1_solve_description').prop('disabled', true);
		$('input[name="tier1_solve_result"]').prop('disabled', true);
		$('input[name="tier1_forward"]').prop('disabled', true);
	}
	
	if(tier2Readonly) {
		$('#tier2_solve_description').prop('disabled', true);
		$('input[name="tier2_solve_result"]').prop('disabled', true);
		$('input[name="tier2_forward"]').prop('disabled', true);
	}
	
	if(tier3Readonly) {
		$('#tier3_solve_description').prop('disabled', true);
		$('input[name="tier3_solve_result"]').prop('disabled', true);
		$('input[name="tier3_forward"]').prop('disabled', true);
	}
	
	@if($job->active_operator_team == 'SCS' or $job->last_operator_team == 'SCS')
	
	if(hardwareReadonly) {
		$('#serial_number').prop('disabled', true);
		$('#product').prop('disabled', true);
		$('#model_part_number').prop('disabled', true);
		$('#malfunction').prop('disabled', true);
	}
	
	if(scsReadonly) {
		$('#scs_cause').prop('disabled', true);
		$('#scs_action').prop('disabled', true);
		$('#scs_action_dtm').prop('disabled', true);
		$('#scs_start_dtm').prop('disabled', true);
		$('#operator_name').prop('disabled', true);
		$('#scs_remark').prop('disabled', true);
		$('#enter_dtm').prop('disabled', true);
	}
	
	@endif
	
	var projects = [
		@foreach($informers as $informer)
		{
			value: "{{ $informer->name }}",
			label: "{{ $informer->name }} | {{ $informer->phone_number }} | {{ $informer->type }}",
		},
		@endforeach
    ];
	
    $( "#informer_name" ).autocomplete({
      //source: projects,
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(projects, request.term);
			
			response(results.slice(0, 10));
		},
	  select: function( event, ui ) {
		var res = ui.item.label.split('|');
		$('#informer_phone_number').val(res[1].trim());
		$('#informer_type_' + res[2].trim()).prop('checked', true);
		$('#description').focus();
      },
    });
	
	@if(Request::user()->team == 'SA')

		$("#sa_rw").change(function() {
			if($(this).is(":checked")) {
				
				$('#sa_rw_call_category').prop('disabled', false);
				$('#sa_rw_primary_system').prop('disabled', false);
				$('#sa_rw_primary_system_ph1').prop('disabled', false);
				$('#sa_rw_primary_system_ph2').prop('disabled', false);
				$('#sa_rw_primary_system_ph3').prop('disabled', false);
				$('#sa_rw_primary_system_ph4').prop('disabled', false);
				$('#sa_rw_secondary_system').prop('disabled', false);
				$('#sa_rw_secondary_system_ph1').prop('disabled', false);
				$('#sa_rw_secondary_system_ph2').prop('disabled', false);
				$('#sa_rw_secondary_system_ph3').prop('disabled', false);
				$('#sa_rw_secondary_system_ph4').prop('disabled', false);
				$('#sa_rw_return_job').prop('disabled', false);
				$('#sa_rw_remark').prop('disabled', false);
				
				$('#sa_rw_call_category').selectize();
				$('#sa_rw_primary_system').selectize();
				$('#sa_rw_primary_system_ph1').selectize();
				$('#sa_rw_primary_system_ph2').selectize();
				$('#sa_rw_primary_system_ph3').selectize();
				$('#sa_rw_primary_system_ph4').selectize();
				$('#sa_rw_secondary_system').selectize();
				$('#sa_rw_secondary_system_ph1').selectize();
				$('#sa_rw_secondary_system_ph2').selectize();
				$('#sa_rw_secondary_system_ph3').selectize();
				$('#sa_rw_secondary_system_ph4').selectize();
			} else {
				$("#sa_rw_call_category").selectize()[0].selectize.destroy();
				$("#sa_rw_primary_system").selectize()[0].selectize.destroy();
				$("#sa_rw_primary_system_ph1").selectize()[0].selectize.destroy();
				$("#sa_rw_primary_system_ph2").selectize()[0].selectize.destroy();
				$("#sa_rw_primary_system_ph3").selectize()[0].selectize.destroy();
				$("#sa_rw_primary_system_ph4").selectize()[0].selectize.destroy();
				$("#sa_rw_secondary_system").selectize()[0].selectize.destroy();
				$("#sa_rw_secondary_system_ph1").selectize()[0].selectize.destroy();
				$("#sa_rw_secondary_system_ph2").selectize()[0].selectize.destroy();
				$("#sa_rw_secondary_system_ph3").selectize()[0].selectize.destroy();
				$("#sa_rw_secondary_system_ph4").selectize()[0].selectize.destroy();
				
				$('#sa_rw_call_category').prop('disabled', true);
				$('#sa_rw_primary_system').prop('disabled', true);
				$('#sa_rw_primary_system_ph1').prop('disabled', true);
				$('#sa_rw_primary_system_ph2').prop('disabled', true);
				$('#sa_rw_primary_system_ph3').prop('disabled', true);
				$('#sa_rw_primary_system_ph4').prop('disabled', true);
				$('#sa_rw_secondary_system').prop('disabled', true);
				$('#sa_rw_secondary_system_ph1').prop('disabled', true);
				$('#sa_rw_secondary_system_ph2').prop('disabled', true);
				$('#sa_rw_secondary_system_ph3').prop('disabled', true);
				$('#sa_rw_secondary_system_ph4').prop('disabled', true);
				$('#sa_rw_return_job').prop('disabled', true);
				$('#sa_rw_remark').prop('disabled', true);
			}
		}).change();
		
	@else
		
		$('#sa_rw_call_category').prop('disabled', true);
		$('#sa_rw_primary_system').prop('disabled', true);
		$('#sa_rw_primary_system_ph1').prop('disabled', true);
		$('#sa_rw_primary_system_ph2').prop('disabled', true);
		$('#sa_rw_primary_system_ph3').prop('disabled', true);
		$('#sa_rw_primary_system_ph4').prop('disabled', true);
		$('#sa_rw_secondary_system').prop('disabled', true);
		$('#sa_rw_secondary_system_ph1').prop('disabled', true);
		$('#sa_rw_secondary_system_ph2').prop('disabled', true);
		$('#sa_rw_secondary_system_ph3').prop('disabled', true);
		$('#sa_rw_secondary_system_ph4').prop('disabled', true);
		$('#sa_rw_return_job').prop('disabled', true);
		$('#sa_rw_remark').prop('disabled', true);
		
	@endif
	
	$('#serial_number').blur(function() {
		$.ajax({
			method: 'GET',
			url: '{{ url("/hw/search") }}',
			data: { 'phase': '{{ $job->phase }}', 'sn': $(this).val() },
			cache: false,
			dataType: 'json',
		})
		.done(function( data ) {
			//$('#hw_search_result').html( data.val1 );
			
			if(data.result) {
				$('#hw_search_result').html('<p class="bg-success">&nbsp;พบในระบบ</p>');
				$('#product').val(data.product);
				$('#model_part_number').val(data.model_part_number);
			} else {
				$('#hw_search_result').html('<p class="bg-warning">&nbsp;ไม่พบในระบบ</p>');
			}
			
		});
		
	}).blur();
});
</script>

@if($action == 'edit')
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
							<dd>{{ $job->active_operator_name() }} [{{ $job->active_operator_team }}]</dd>
							<dt>Phone Number</dt>
							<dd>{{ $job->active_operator_phone_number() }}</dd>
							@endif
							
						</dl>
					</div>
				
			</div>
		</div>
	</div>
</div>
@endif

@if($action == 'create')
<form class="form-horizontal" role="form" action="{{ url('/job') }}" method="post" autocomplete="on">
@elseif($action == 'edit')
<form class="form-horizontal" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
@endif

@if(($job->closed == false) or ($job->closed == true and $job->cc_confirm_closed == false))
{!! csrf_field() !!}
@endif

@if(Request::user()->team == 'SA' and $job->closed == true and $job->cc_confirm_closed == true 
	and ($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS'))
	{!! csrf_field() !!}
@endif

@if($action == 'edit')
<input name="_method" type="hidden" value="patch"/>
@endif
	
@if($job->active_operator_team == 'SCS' or $job->last_operator_team == 'SCS')
	
	@if(Request::user()->team == 'CC')
	<input name="_action" type="hidden" value="send_scs"/>
	@endif

	<div class="row">


		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Hardware</div>
				<div class="panel-body">
						
						<div class="form-group">
							<label class="col-md-4 control-label">หมายเลขอุปกรณ์</label>
							<div class="col-md-8">
								<input required class="form-control" id="serial_number" name="serial_number" type="text" value="{{ $job->scsjob ? $job->scsjob->serial_number : '' }}" placeholder="Require"/>
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
								<input required class="form-control" id="product" name="product" type="text" value="{{ $job->scsjob ? $job->scsjob->product : '' }}"  placeholder="Require"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">รุ่นอุปกรณ์</label>
							<div class="col-md-8">
								<input class="form-control" id="model_part_number" name="model_part_number" type="text" value="{{ $job->scsjob ? $job->scsjob->model_part_number : '' }}"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">อาการขัดข้องของอุปกรณ์ที่พบ</label>
							<div class="col-md-8">
								<textarea class="form-control" id="malfunction" name="malfunction">{{ $job->scsjob ? $job->scsjob->malfunction : '' }}</textarea>
							</div>
						</div>
						
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">SCS</div>
				<div class="panel-body">
						
						<div class="form-group">
							<label class="col-md-3 control-label">การดำเนินการแก้ไข</label>
							<div class="col-md-9">
								<textarea required class="form-control" id="scs_action" name="scs_action" placeholder="Require">{{ $job->scsjob ? $job->scsjob->action : '' }}</textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">เวลาที่เริ่มแก้ไข</label>
							<div class="col-md-9">
								<input required class="form-control" id="scs_start_dtm" name="scs_start_dtm" type="datetime-local" value="{{ $job->scsjob ? ($job->scsjob->start_dtm ? date('Y-m-d\TH:i', strtotime($job->scsjob->start_dtm)) : '') : '' }}" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">เวลาที่แก้ไขเสร็จ</label>
							<div class="col-md-9">
								<input required class="form-control" id="scs_action_dtm" name="scs_action_dtm" type="datetime-local" value="{{ $job->scsjob ? ($job->scsjob->action_dtm ? date('Y-m-d\TH:i', strtotime($job->scsjob->action_dtm)) : '') : '' }}" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">ผู้ดำเนินการ</label>
							<div class="col-md-9">
								<input class="form-control" id="operator_name" name="operator_name" type="text" value="{{ $job->scsjob ? $job->scsjob->operator_name : '' }}"/>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label">สาเหตุ</label>
							<div class="col-md-9">
								<textarea class="form-control" id="scs_cause" name="scs_cause">{{ $job->scsjob ? $job->scsjob->cause : '' }}</textarea>
							</div>
						</div>
						
				
						<div class="form-group">
							<label class="col-md-3 control-label">หมายเหตุ</label>
							<div class="col-md-9">
								<textarea class="form-control" id="scs_remark" name="scs_remark">{{ $job->scsjob ? $job->scsjob->remark : '' }}</textarea>
							</div>
						</div>

						
						
				</div>
			</div>
		</div>
		

	</div>
	@endif
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Infomation</div>
				<div class="panel-body">
			
					<div class="form-group">
						<label class="col-md-4 control-label">หน่วยงาน</label>
						<div class="col-md-8">
							<select required class="form-control" id="department" name="department">
								<option value="">Require</option>
								@foreach ($departments as $department)
								<option value="{{ $department->id }}" {{ $job->department_id==$department->id ? 'selected' : '' }}>[DOL{{ $department->phase }}] {{ $department->name }}</option>
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
			 
                    @if (Request::user()->team != 'DOL')
					<div class="form-group">
						<label class="col-md-4 control-label">ประเภทผู้แจ้ง</label>
						<div class="col-md-8">
							<label class="radio-inline">
								<input required type="radio" id="informer_type_C" name="informer_type" value="C" {{ $job->informer_type=='C' ? 'checked' : '' }} >ลูกค้า
							</label>
							<label class="radio-inline">
								<input required type="radio" id="informer_type_I" name="informer_type" value="I" {{ $job->informer_type=='I' ? 'checked' : '' }} >ภายใน (บริษัท)
							</label>
						</div>
					</div>
                    @endif
					
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
									<option value="{{ $call_category->id }}" {{ $job->call_category_id == $call_category->id ? 'selected' : '' }}>[{{ $call_category->code }}] {{ $call_category->problem_group }}</option>
								@endforeach
							</select>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-4 control-label">ระบบงานหลัก</label>
						<div class="col-md-8">
							<div class="primary_system">
								<select class="form-control" id="primary_system" name="primary_system">
									<option value=""></option>
								</select>
							</div>
							<div class="primary_system_ph1">
								<select class="form-control" id="primary_system_ph1" name="primary_system_ph1">
									<option value=""></option>
									@foreach ($systems_ph1 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="primary_system_ph2">
								<select class="form-control" id="primary_system_ph2" name="primary_system_ph2">
									<option value=""></option>
									@foreach ($systems_ph2 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="primary_system_ph3">
								<select class="form-control" id="primary_system_ph3" name="primary_system_ph3">
									<option value=""></option>
									@foreach ($systems_ph3 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="primary_system_ph4">
								<select class="form-control" id="primary_system_ph4" name="primary_system_ph4">
									<option value=""></option>
									@foreach ($systems_ph4 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-4 control-label">ระบบงานรอง</label>
						<div class="col-md-8">
							<div class="secondary_system">
								<select class="form-control" id="secondary_system" name="secondary_system">
									<option value=""></option>
								</select>
							</div>
							<div class="secondary_system_ph1">
								<select class="form-control" id="secondary_system_ph1" name="secondary_system_ph1">
									<option value=""></option>
									@foreach ($systems_ph1 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="secondary_system_ph2">
								<select class="form-control" id="secondary_system_ph2" name="secondary_system_ph2">
									<option value=""></option>
									@foreach ($systems_ph2 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="secondary_system_ph3">
								<select class="form-control" id="secondary_system_ph3" name="secondary_system_ph3">
									<option value=""></option>
									@foreach ($systems_ph3 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="secondary_system_ph4">
								<select class="form-control" id="secondary_system_ph4" name="secondary_system_ph4">
									<option value=""></option>
									@foreach ($systems_ph4 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label">Return Job</label>
						<div class="col-md-8">
							<label class="checkbox-inline">
								<input type="checkbox" id="return_job" name="return_job" value="1" {{ $job->return_job=='1' ? 'checked' : '' }} >&nbsp;
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

		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Tier1</div>
				<div class="panel-body">
				
					<div class="form-group">
						<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
						<div class="col-md-9">
							<textarea class="form-control" id="tier1_solve_description" name="tier1_solve_description">{{ $job->tier1_solve_description }}</textarea>
						</div>
					</div>
				
					<div class="form-group">
						<label class="col-md-3 control-label">ผลการแก้ไข</label>
						<div class="col-md-9">
							<label class="radio-inline">
								<input required type="radio" id="tier1_solve_result_1" name="tier1_solve_result" value="1" {{ $job->tier1_solve_result=='1' ? 'checked' : '' }} >ได้
							</label>
							<label class="radio-inline">
								<input required type="radio" id="tier1_solve_result_0" name="tier1_solve_result" value="0" {{ $job->tier1_solve_result=='0' ? 'checked' : '' }} >ไม่ได้
							</label>
						</div>
					</div>
				
					<div class="form-group">
						<label class="col-md-3 control-label">ส่งต่อ</label>
						<div class="col-md-9">
							<label class="radio-inline">
								<input type="radio" id="tier1_forward_SP" name="tier1_forward" value="SP" {{ $job->tier1_forward=='SP' ? 'checked' : '' }} >Support
							</label>
							<label class="radio-inline">
								<input type="radio" name="tier1_forward" value="SA" {{ $job->tier1_forward=='SA' ? 'checked' : '' }} >SA
							</label>
							<label class="radio-inline">
								<input type="radio" name="tier1_forward" value="NW" {{ $job->tier1_forward=='NW' ? 'checked' : '' }} >Network
							</label>
							<label class="radio-inline">
								<input type="radio" name="tier1_forward" value="ST" {{ $job->tier1_forward=='ST' ? 'checked' : '' }} >System
							</label>
							<label class="radio-inline">
								<input type="radio" name="tier1_forward" value="SCS" {{ $job->tier1_forward=='SCS' ? 'checked' : '' }} >SCS
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Tier2</div>
				<div class="panel-body">
				
				<div class="form-group">
					<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
					<div class="col-md-9">
						<textarea class="form-control" id="tier2_solve_description" name="tier2_solve_description" placeholder="Require">{{ $job->tier2_solve_description }}</textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">ผลการแก้ไข</label>
					<div class="col-md-9">
						<label class="radio-inline">
							<input type="radio" id="tier2_solve_result_1" name="tier2_solve_result" value="1" {{ $job->tier2_solve_result=='1' ? 'checked' : '' }} >ได้
						</label>
						<label class="radio-inline">
							<input type="radio" id="tier2_solve_result_0" name="tier2_solve_result" value="0" {{ $job->tier2_solve_result=='0' ? 'checked' : '' }} >ไม่ได้
						</label>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">ส่งต่อ</label>
					<div class="col-md-9">
						<label class="radio-inline">
							<input type="radio" id="tier2_forward_SA" name="tier2_forward" value="SA" {{ $job->tier2_forward=='SA' ? 'checked' : '' }} >SA
						</label>
						<label class="radio-inline">
							<input type="radio" name="tier2_forward" value="NW" {{ $job->tier2_forward=='NW' ? 'checked' : '' }} >Network
						</label>
						<label class="radio-inline">
							<input type="radio" name="tier2_forward" value="ST" {{ $job->tier2_forward=='ST' ? 'checked' : '' }} >System
						</label>
						<label class="radio-inline">
							<input type="radio" name="tier2_forward" value="SCS" {{ $job->tier2_forward=='SCS' ? 'checked' : '' }} >SCS
						</label>
					</div>
				</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Tier3</div>
				<div class="panel-body">
				
					<div class="form-group">
						<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
						<div class="col-md-9">
							<textarea class="form-control" id="tier3_solve_description" name="tier3_solve_description" placeholder="Require">{{ $job->tier3_solve_description }}</textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">ผลการแก้ไข</label>
						<div class="col-md-9">
							<label class="radio-inline">
								<input type="radio" id="tier3_solve_result_1" name="tier3_solve_result" value="1" {{ $job->tier3_solve_result=='1' ? 'checked' : '' }} >ได้
							</label>
							<label class="radio-inline">
								<input type="radio" id="tier3_solve_result_0" name="tier3_solve_result" value="0" {{ $job->tier3_solve_result=='0' ? 'checked' : '' }} >ไม่ได้
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">ส่งต่อ</label>
						<div class="col-md-9">
							<label class="radio-inline">
								<input type="radio" id="tier3_forward_SCS" name="tier3_forward" value="SCS" {{ $job->tier3_forward=='SCS' ? 'checked' : '' }} >SCS
							</label>
						</div>
					</div>
					
					@if(($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
						and ($job->active_operator_team != 'NW' and $job->last_operator_team != 'NW')
						and ($job->active_operator_team != 'ST' and $job->last_operator_team != 'ST'))
					<div class="form-group">
						<label class="col-md-3 control-label">Review</label>
						<div class="col-md-9">
							<label class="checkbox-inline">
								<input type="checkbox" id="sa_rw" name="sa_rw" value="1" {{ $job->sa_rw=='1' ? 'checked' : '' }} {{ Request::user()->team != 'SA' ? 'disabled="disabled"' : '' }}>&nbsp;
							</label>
						</div>
					</div>
				
					<div class="form-group">
						<label class="col-md-3 control-label">กลุ่มปัญหา</label>
						<div class="col-md-9">
							<select class="form-control" id="sa_rw_call_category" name="sa_rw_call_category">
								<option value=""></option>
								@foreach ($call_categories as $call_category)
									<option value="{{ $call_category->id }}" {{ $job->sa_rw_call_category_id == $call_category->id ? 'selected' : '' }}>[{{ $call_category->code }}] {{ $call_category->problem_group }}</option>
								@endforeach
							</select>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-3 control-label">ระบบงานหลัก</label>
						<div class="col-md-9">
							<div class="sa_rw_primary_system">
								<select class="form-control" id="sa_rw_primary_system" name="sa_rw_primary_system">
									<option value=""></option>
								</select>
							</div>
							<div class="sa_rw_primary_system_ph1">
								<select class="form-control" id="sa_rw_primary_system_ph1" name="sa_rw_primary_system_ph1">
									<option value=""></option>
									@foreach ($systems_ph1 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="sa_rw_primary_system_ph2">
								<select class="form-control" id="sa_rw_primary_system_ph2" name="sa_rw_primary_system_ph2">
									<option value=""></option>
									@foreach ($systems_ph2 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="sa_rw_primary_system_ph3">
								<select class="form-control" id="sa_rw_primary_system_ph3" name="sa_rw_primary_system_ph3">
									<option value=""></option>
									@foreach ($systems_ph3 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="sa_rw_primary_system_ph4">
								<select class="form-control" id="sa_rw_primary_system_ph4" name="sa_rw_primary_system_ph4">
									<option value=""></option>
									@foreach ($systems_ph4 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_primary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-3 control-label">ระบบงานรอง</label>
						<div class="col-md-9">
							<div class="sa_rw_secondary_system">
								<select class="form-control" id="sa_rw_secondary_system" name="sa_rw_secondary_system">
									<option value=""></option>
								</select>
							</div>
							<div class="sa_rw_secondary_system_ph1">
								<select class="form-control" id="sa_rw_secondary_system_ph1" name="sa_rw_secondary_system_ph1">
									<option value=""></option>
									@foreach ($systems_ph1 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="sa_rw_secondary_system_ph2">
								<select class="form-control" id="sa_rw_secondary_system_ph2" name="sa_rw_secondary_system_ph2">
									<option value=""></option>
									@foreach ($systems_ph2 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="sa_rw_secondary_system_ph3">
								<select class="form-control" id="sa_rw_secondary_system_ph3" name="sa_rw_secondary_system_ph3">
									<option value=""></option>
									@foreach ($systems_ph3 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="sa_rw_secondary_system_ph4">
								<select class="form-control" id="sa_rw_secondary_system_ph4" name="sa_rw_secondary_system_ph4">
									<option value=""></option>
									@foreach ($systems_ph4 as $system)
										<option class="system_ph{{ $system->phase }}" value="{{ $system->id }}" {{ $job->sa_rw_secondary_system_id==$system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">Return Job</label>
						<div class="col-md-9">
							<label class="checkbox-inline">
								<input type="checkbox" id="sa_rw_return_job" name="sa_rw_return_job" value="1" {{ $job->sa_rw_return_job=='1' ? 'checked' : '' }} >&nbsp;
							</label>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">หมายเหตุ</label>
						<div class="col-md-9">
							<textarea class="form-control" id="sa_rw_remark" name="sa_rw_remark">{{ $job->sa_rw_remark }}</textarea>
						</div>
					</div>
					@endif
					
				</div>
			</div>
		</div>
		
	</div>
	
	@if(($job->closed == false) or ($job->closed == true and $job->cc_confirm_closed == false))
		@if((Request::user()->id == $job->active_operator_id or empty($job->id)) 
			or (Request::user()->id == $job->last_operator_id and empty($job->active_operator_id))
			or (Request::user()->team == 'SA' 
				and ($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
				and ($job->active_operator_team != 'NW' and $job->last_operator_team != 'NW')
				and ($job->active_operator_team != 'ST' and $job->last_operator_team != 'ST')
				)
			or (Request::user()->team == 'CC'
				and $job->active_operator_team == 'SCS'
				and empty($job->active_operator_id)))
				
	<div class="form-group">
		<div class="col-md-4 col-md-offset-4">
			<input class="form-control btn btn-success" type="submit" value="บันทึก"/>
		</div>
	</div>
	
		@endif
	@endif
	
	@if(Request::user()->team == 'SA' and $job->closed == true and $job->cc_confirm_closed == true 
		and ($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
		and ($job->active_operator_team != 'NW' and $job->last_operator_team != 'NW')
		and ($job->active_operator_team != 'ST' and $job->last_operator_team != 'ST'))
		<div class="form-group">
			<div class="col-md-4 col-md-offset-4">
				<input class="form-control btn btn-success" type="submit" value="บันทึก"/>
			</div>
		</div>
	@endif
</form>

@if(Request::user()->team == 'CC' and $job->closed == true and $job->cc_confirm_closed == false)
<form class="form-horizontal" role="form" action="{{ url('/job/'.$job->id) }}" method="post">
	{!! csrf_field() !!}
	<input name="_method" type="hidden" value="patch"/>
	<input name="_action" type="hidden" value="confirm_closed"/>
	<div class="form-group">
		<div class="col-md-4 col-md-offset-4">
			
			<input class="form-control btn btn-info" type="submit" value="ปิดงาน"/>
		</div>
	</div>
</form>
@endif

