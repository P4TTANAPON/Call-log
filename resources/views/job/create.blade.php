@extends('layouts.app')

@section('job_active')
active
@endsection

@section('information')
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
							<option value="{{ $department->id }}">
								[DOL{{ $department->phase }}] {{ $department->name }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">ชื่อผู้แจ้ง</label>
				<div class="col-md-8">
					<input required class="form-control" id="informer_name" name="informer_name" type="text" placeholder="Require"/>
				</div>
			</div>

			<!-- <div class="form-group">
				<label class="col-md-4 control-label">ชื่อผู้แจ้ง</label>
				<div class="col-md-8">
					<div class="input-group">
		                <span class="input-group-addon">คุณ</span>
		                <input required class="form-control" id="informer_name" name="informer_name" type="text" placeholder="Require"/>
		            </div>
	            </div>
			</div> -->
			
	
			<div class="form-group">
				<label class="col-md-4 control-label">เบอร์โทร</label>
				<div class="col-md-8">
					<input required class="form-control" id="informer_phone_number" name="informer_phone_number" type="text" placeholder="Require"/>
				</div>
			</div>
            
            @if (Request::user()->team != 'DOL')
			<div class="form-group">
				<label class="col-md-4 control-label">ประเภทผู้แจ้ง</label>
				<div class="col-md-8">
					<label class="radio-inline">
						<input required type="radio" id="informer_type_C" name="informer_type" value="C" >ลูกค้า
					</label>
					<label class="radio-inline">
						<input required type="radio" id="informer_type_I" name="informer_type" value="I" >ภายใน (บริษัท)
					</label>
				</div>
			</div>
            @endif
			
			<div class="form-group">
				<label class="col-md-4 control-label">Counter</label>
				<div class="col-md-8">
					<input class="form-control" id="counter" name="counter" type="text"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Screen ID</label>
				<div class="col-md-8">
					<input class="form-control" id="screen_id" name="screen_id" type="text"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Software Version</label>
				<div class="col-md-8">
					<input class="form-control" id="sw_version" name="sw_version" type="text"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">รายละเอียดปัญหา</label>
				<div class="col-md-8">
					<textarea required class="form-control" id="description" name="description" placeholder="Require"></textarea>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-md-4 control-label">กลุ่มปัญหา</label>
				<div class="col-md-8">
					<select required class="form-control" id="call_category" name="call_category">
						<option value="">Require</option>
						@foreach ($call_categories as $call_category)
							<option value="{{ $call_category->id }}" >
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
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph2">
						<select class="form-control" id="primary_system_ph2" name="primary_system_ph2">
							<option value=""></option>
							@foreach ($systems_ph2 as $system)
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph3">
						<select class="form-control" id="primary_system_ph3" name="primary_system_ph3">
							<option value=""></option>
							@foreach ($systems_ph3 as $system)
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph4">
						<select class="form-control" id="primary_system_ph4" name="primary_system_ph4">
							<option value=""></option>
							@foreach ($systems_ph4 as $system)
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
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
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph2">
						<select class="form-control" id="secondary_system_ph2" name="secondary_system_ph2">
							<option value=""></option>
							@foreach ($systems_ph2 as $system)
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph3">
						<select class="form-control" id="secondary_system_ph3" name="secondary_system_ph3">
							<option value=""></option>
							@foreach ($systems_ph3 as $system)
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="select_system_ph4">
						<select class="form-control" id="secondary_system_ph4" name="secondary_system_ph4">
							<option value=""></option>
							@foreach ($systems_ph4 as $system)
								<option value="{{ $system->id }}">[{{ $system->flag }}] {{ $system->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">Return Job</label>
				<div class="col-md-8">
					<label class="checkbox-inline">
						<input type="checkbox" id="return_job" name="return_job" value="1">&nbsp;
					</label>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4 control-label">หมายเหตุ</label>
				<div class="col-md-8">
					<textarea class="form-control" id="remark" name="remark"></textarea>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection

@section('tier1')
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier1</div>
		
		<div class="panel-body form-horizontal">
			<div class="form-group">
				<label class="col-md-3 control-label">บันทึกการแก้ไข</label>
				<div class="col-md-9">
					<textarea class="form-control" id="tier1_solve_description" name="tier1_solve_description"></textarea>
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-md-3 control-label">ผลการแก้ไข</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input required type="radio" id="tier1_solve_result_1" name="tier1_solve_result" value="1">ได้
					</label>
					<label class="radio-inline">
						<input required type="radio" id="tier1_solve_result_0" name="tier1_solve_result" value="0">ไม่ได้
					</label>
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-md-3 control-label">ส่งต่อ</label>
				<div class="col-md-9">
					<label class="radio-inline">
						<input type="radio" id="tier1_forward_SP" name="tier1_forward" value="SP">Support
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="SA">SA
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="NW">Network
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="ST">System
					</label>
					<label class="radio-inline">
						<input type="radio" name="tier1_forward" value="SCS">Vender
					</label>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection

@section('tier2')
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier2</div>
	</div>
</div>
@endsection

@section('tier3')
<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Tier3</div>
	</div>
</div>
@endsection

@section('content')
<script>
$(function() {
	$('#tier1_solve_result_1').change(function() {
        if($(this).is(":checked")) {
            $('input[name="tier1_forward"]').prop('checked', false).prop('disabled', true);
        } 
    });
	
	$('#tier1_solve_result_0').change(function() {
        if($(this).is(":checked")) {
            $('#tier1_forward_SP').prop('checked', true).prop('disabled', false);
        }
    });
	
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

	var projects = [
		@foreach ($informers as $informer) {
			value: "{{ trim($informer->name) }}",
			label: "{{ $informer->name }} | {{ $informer->phone_number }} | {{ $informer->type }}",
		},
		@endforeach
	];

	$("#informer_name").autocomplete({
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
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Job<small> - create</small></strong></div>

                <div class="panel-body">
					
					@include('common.messages')
					@include('common.errors')
				
					<a href="{{ url('/job') }}" class="btn btn-default"><span class="glyphicon glyphicon-th-large"></span> Index</a>
					
					<p>&nbsp;</p>
					
					<div class="row">
						<form class="form-horizontal" role="form" action="{{ url('/job') }}" method="post">
							{{ csrf_field() }}
							
							@yield('information')
							@yield('tier1')
							@yield('tier2')
							@yield('tier3')
							
							<div class="form-group"> 
								<div class="col-md-4 col-md-offset-4">
									<button class="form-control btn btn-success" type="submit">
										บันทึก
									</button>
								</div>
							</div>
						</form>
					</div>
					
                </div>
            </div>
        </div>
    </div>
</div>
@endsection