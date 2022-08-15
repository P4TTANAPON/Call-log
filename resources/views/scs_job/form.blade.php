
	
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">System Infomation</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="col-md-5">
						<!--<div><strong>Ticket No</strong> : {{ $job->ticket_no }}</div>
						<div><strong>Created at</strong> : {{ $job->created_at }}</div>
						<div><strong>โครงการ</strong> : {{ $job->department->phase }}</div>
						<div><strong>สำนักงาน</strong> : {{ $job->department->name }}</div>-->
						<dl class="dl-horizontal">
							<dt>Ticket No</dt>
							<dd>{{ $job->ticket_no }}</dd>
							<dt>Created at</dt>
							<dd>{{ $job->created_at }}</dd>
							<dt>โครงการ</dt>
							<dd>{{ $job->department->phase }}</dd>
							<dt>สำนักงาน</dt>
							<dd>{{ $job->department->name }}</dd>
							<dt>รายละเอียดปัญหา</dt>
							<dd>{{ $job->description }}</dd>
						</dl>
					</div>
					<div class="col-md-7">
						<!--<div><strong>รายละเอียดปัญหา</strong> : {{ $job->description }}</div>
						<div><strong>บันทึกการแก้ไข 1</strong> : {{ $job->tier1_solve_description }}</div>
						<div><strong>บันทึกการแก้ไข 2</strong> : {{ $job->tier2_solve_description }}</div>
						<div><strong>บันทึกการแก้ไข 3</strong> : {{ $job->tier3_solve_description }}</div>
						<div><strong>หมายเหตุ</strong> : {{ $job->remark }}</div>-->
						<dl class="dl-horizontal">
							<dt>บันทึกการแก้ไข 1</dt>
							<dd>{{ $job->tier1_solve_description }}</dd>
							<dt>บันทึกการแก้ไข 2</dt>
							<dd>{{ $job->tier2_solve_description }}</dd>
							<dt>บันทึกการแก้ไข 3</dt>
							<dd>{{ $job->tier3_solve_description }}</dd>
							<dt>หมายเหตุ</dt>
							<dd>{{ $job->remark }}</dd>
						</dl>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Search</div>
			<div class="panel-body">
				<form role="form" method="get">
					<div class="row">
						<div class="form-group col-md-6">
							<label><strong>หมายเลขอุปกรณ์ </strong></label> - 
							<input type="hidden" name="ph" value="{{ $job->department->phase }}" />
							<input required class="form-control" name="search_serial_number" type="text" value="{{ old('search_serial_number') }}"/>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<input class="btn btn-default" type="submit" value="Submit" /> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	@if($search)
	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Search Result</div>
			<div class="panel-body">
				@if(!$hw)
					<div class="alert alert-warning">
						<strong>Warning!</strong> ไม่พบอุปกรณ์
					</div>
				@else
					<!--<div><strong>Serial Number</strong> : {{ $hw->serial_number }}</div>
					<div><strong>Product</strong> : {{ $hw->product }}</div>
					<div><strong>Model / Part Number</strong> : {{ $hw->model_part_number }}</div>
					<div><strong>Install Location</strong> : {{ $hw->install_location }}</div>
					<div><strong>Note</strong> : {{ $hw->note }}</div>-->
					
					<dl class="dl-horizontal">
						<dt>Serial Number</dt>
						<dd>{{ $hw->serial_number }}</dd>
						<dt>Product</dt>
						<dd>{{ $hw->product }}</dd>
						<dt>Model</dt>
						<dd>{{ $hw->model_part_number }}</dd>
						<dt>Install Location</dt>
						<dd>{{ $hw->install_location }}</dd>
						<dt>Note</dt>
						<dd>{{ $hw->note }}</dd>
					</dl>
				@endif
			</div>
			
		</div>
	</div>
	
	<form class="form-horizontal" role="form" action="{{ url('/scs/create/' . $job->id) }}" method="post">

	{!! csrf_field() !!}
	
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">Infomation</div>
				<div class="panel-body">
				
					
					@if($action=='edit')
					<input name="_method" type="hidden" value="patch"/>
					@endif
					
					@if(!$hw)
					
					<div class="form-group">
						<label class="col-md-4 control-label">หมายเลขอุปกรณ์</label>
						<div class="col-md-8">
							<input required readonly class="form-control" name="serial_number" type="text" value="{{ Request::get('search_serial_number') }}"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label">อุปกรณ์ที่ขัดข้อง</label>
						<div class="col-md-8">
							<input required class="form-control" name="product" type="text" value=""  placeholder="Require"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label">รุ่นอุปกรณ์</label>
						<div class="col-md-8">
							<input required class="form-control" name="model_part_number" type="text" value=""  placeholder="Require"/>
						</div>
					</div>
					
					<input type="hidden" name="hardware_id" value="" />
					
					@else
						
					<input type="hidden" name="product" value="{{ $hw->product }}"/>
					<input type="hidden" name="model_part_number" value="{{ $hw->model_part_number }}"/>
					<input type="hidden" name="serial_number" value="{{ $hw->serial_number }}"/>
					<input type="hidden" name="hardware_id" value="{{ $hw->id }}" />
					
					@endif
					
					<div class="form-group">
						<label class="col-md-4 control-label">อาการขัดข้องของอุปกรณ์ที่พบ</label>
						<div class="col-md-8">
							<textarea required class="form-control" rows="2" name="malfunction" placeholder="Require"></textarea>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-4 control-label">สาเหตุ</label>
						<div class="col-md-8">
							<textarea class="form-control" rows="2" name="cause"></textarea>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-4 control-label">การดำเนินการแก้ไข</label>
						<div class="col-md-8">
							<textarea class="form-control" rows="2" name="action"></textarea>
						</div>
					</div>
			
					<div class="form-group">
						<label class="col-md-4 control-label">หมายเหตุ</label>
						<div class="col-md-8">
							<textarea class="form-control" rows="2" name="remark"></textarea>
						</div>
					</div>
				
				</div>
				
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-4 col-md-offset-4">
				<input class="form-control btn btn-success" type="submit" value="บันทึก"/>
			</div>
		</div>
	
	</form>
	
	@endif
</form>