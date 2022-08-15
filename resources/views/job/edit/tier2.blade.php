<script>
	$(function() {
		$('#tier2_solve_result_1').change(function() {
			if ($(this).is(":checked")) {
				$('input[name="tier2_forward"]').prop('checked', false).prop('disabled', true);
			}
		}).dblclick(function() {
			if ($(this).is(":checked")) {
				$(this).prop('checked', false);
				$('input[name="tier2_forward"]').prop('checked', false);
			}
		});

		$('#tier2_solve_result_0').change(function() {
			if ($(this).is(":checked")) {
				$('#tier2_forward_SA').prop('checked', true).prop('disabled', false);
				$('input[name="tier2_forward"]').prop('disabled', false);
			}
		}).dblclick(function() {
			if ($(this).is(":checked")) {
				$(this).prop('checked', false);
				$('input[name="tier2_forward"]').prop('checked', false);
			}
		});

		$('#call_category').selectize();
		$('#primary_system').selectize();
		$('#secondary_system').selectize();

		var solve_desc = [
			@foreach($solve_descriptions as $solve_description) {
				value: "{{ trim($solve_description->description) }}",
				label: "{{ trim($solve_description->description) }}",
			},
			@endforeach
		];
		
		

		$("#tier2_solve_description").autocomplete({
			source: function(request, response) {
				var results = $.ui.autocomplete.filter(solve_desc, request.term);
				response(results.slice(0, 10));
				//alert(results);
			},
			select: function(event, ui) {
				//var res = ui.item.label.split('|');
				$('#tier2_solve_result_1').prop('checked', true);
				//$('#informer_phone_number').val(res[1].trim());
				//$('#informer_type_' + res[2].trim()).prop('checked', true);
				//$('#description').focus();
			},
		});
	});
</script>

<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier2</div>

		@if($job->tier2_solve_user or Request::user()->team == 'OBS')
		<!-- ROOT -->

		<div class="panel-body form-horizontal">
			<div class="form-group">
				<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
				<div class="col-md-9">
					<textarea required class="form-control" id="tier2_solve_description" name="tier2_solve_description" placeholder="Require">{{ $job->tier2_solve_description }}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">กลุ่มปัญหา</label>
				<div class="col-md-9">
					<select required class="form-control" id="call_category" name="call_category">
						@foreach ($call_categories as $call_category)
						<option value="{{ $call_category->id }}" {{ $job->call_category_id == $call_category->id ? 'selected' : '' }}>
							[{{ $call_category->code }}] {{ $call_category->problem_group }}
						</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">ระบบงานหลัก</label>
				<div class="col-md-9">
					<div class="select_system_ph1">
						<select class="form-control" id="primary_system" name="primary_system">
							<option value=""></option>
							@foreach ($systems as $system)
							<option value="{{ $system->id }}" {{ $job->primary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">ระบบงานรอง</label>
				<div class="col-md-9">
					<div class="select_system_ph1">
						<select class="form-control" id="secondary_system" name="secondary_system">
							<option value=""></option>
							@foreach ($systems as $system)
							<option value="{{ $system->id }}" {{ $job->secondary_system_id == $system->id ? 'selected' : '' }}>[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">หมายเหตุ</label>
				<div class="col-md-9">
					<textarea class="form-control" id="remark" name="remark">{{ $job->remark }}</textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">ผลการแก้ไข</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier2_solve_result_1" name="tier2_solve_result" value="1" {{ $job->tier2_solve_result == '1' ? 'checked' : '' }}>ได้
					</label>
					<label class="radio-inline">
						<input type="radio" id="tier2_solve_result_0" name="tier2_solve_result" value="0" {{ $job->tier2_solve_result == '0' ? 'checked' : '' }}>ไม่ได้
					</label>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label">ส่งต่อ</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier2_forward_SA" name="tier2_forward" value="SA" {{ $job->tier2_forward == 'SA' ? 'checked' : '' }}>SA
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier2_forward" value="NW" {{ $job->tier2_forward == 'NW' ? 'checked' : '' }}>Network
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier2_forward" value="ST" {{ $job->tier2_forward == 'ST' ? 'checked' : '' }}>System
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier2_forward" value="SCS" {{ $job->tier2_forward == 'SCS' ? 'checked' : '' }}>Vender
					</label>
				</div>
			</div>

		</div>

		@endif

	</div>
</div>