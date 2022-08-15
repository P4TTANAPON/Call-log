<script>
	$(function() {

		$(function() {
			//$('#serial_number').selectize();
			$.ajax({
				method: 'GET',
				url: '{{ url("/hw/all") }}',
				data: {
					'hw_id': '{{ $job->scsjob ? $job->scsjob->hw_id : ""  }}'
				},
				cache: false
			}).done(function(html) {
				$("#serial_number").autocomplete({
					source: html.split(','),
					search: function(event, ui) {
						$('#hw_search_result').html('');
						$('#product').val('');
						$('#model_part_number').val('');
						$('#hw_search_result_val').val('0');
					},
					select: function(event, ui) {

						$.ajax({
							method: 'GET',
							url: '{{ url("/hw/search") }}',
							data: {
								'phase': '{{ $job->phase }}',
								'department': '{{ $job->department_id  }}',
								'serial_number': ui.item.label
							},
							cache: false,
							dataType: 'json',
						}).done(function(data) {

							if (data.result) {
								$('#hw_search_result').html('<p class="bg-success">&nbsp;พบในระบบ</p>');
								$('#product').val(data.product);
								$('#model_part_number').val(data.model_part_number);
								$('#hw_search_result_val').val('1');
							} else {
								$('#hw_search_result').html('<p class="bg-warning">&nbsp;ไม่พบในระบบ</p>');
								$('#product').val('');
								$('#model_part_number').val('');
								$('#hw_search_result_val').val('0');
							}
						});
					}
				});
			});
		});



		var checkNew = false;

		$('input[name="tier1_forward"]').change(function() {
			if ($(this).val() != 'SCS') {
				$('#serial_number').attr('required', false);
				$('#product').attr('required', false);
			} else {
				$('#serial_number').attr('required', true);
				$('#product').attr('required', true);
			}
		});

		//$('#serial_number').selectize();

	});
</script>
<div class="panel panel-default">
	<div class="panel-heading">Hardware</div>
	<div class="panel-body">
		<input type="hidden" name="CCSCS" value="1" />

		<div class="form-group">
			<label class="col-md-4 control-label">หมายเลขอุปกรณ์</label>
			<div class="col-md-8">
				<input class="form-control" id="serial_number" name="serial_number" placeholder="Require" value="{{ $job->scsjob ? $job->scsjob->serial_number : '' }}">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-4"></div>
			<div class="col-md-8">
				<div id="hw_search_result" name="hw_search_result"></div>
				<input class="form-control" id="hw_search_result_val" name="hw_search_result_val" type="text" style="display: none;" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">อุปกรณ์ที่ขัดข้อง</label>
			<div class="col-md-8">
				<input required class="form-control" id="product" name="product" type="text" placeholder="Require" value="{{ $job->scsjob ? $job->scsjob->product : '' }}" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">รุ่นอุปกรณ์</label>
			<div class="col-md-8">
				<input class="form-control" id="model_part_number" name="model_part_number" type="text" value="{{ $job->scsjob ? $job->scsjob->model_part_number : '' }}" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-4 control-label">Ticket</label>
			<!--อาการขัดข้องของอุปกรณ์ที่พบ -->
			<div class="col-md-8">
				<input class="form-control" id="malfunction" name="malfunction" type="text" value="{{ $job->scsjob ? $job->scsjob->malfunction : '' }}" />
			</div>
		</div>


	</div>
</div>