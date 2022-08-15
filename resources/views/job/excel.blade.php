<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<style>
.td-center {
	text-align: center;
	vertical-align: middle;
}
td {
   border: 1px solid black !important; 
}
</style>
		<tr>
			<td class="td-center" colspan="12"><strong>TIER1 Helpdesk</strong></td>
			<td class="td-center" colspan="3"><strong>TIER2 Support</strong></td>
			<td class="td-center" colspan="3"><strong>TIER3</strong></td>
			<td class="td-center" colspan="5"><strong>Results</strong></td>
		</tr>
		<tr>
			<td class="td-center"><strong>วัน - เวลา</strong></td>
			<td class="td-center"><strong>หน่วยงาน</strong></td>
			<td class="td-center"><strong>โครงการ</strong></td>
			<td class="td-center"><strong>ชื่อผู้แจ้ง</strong></td>
			<td class="td-center"><strong>โทร</strong></td>
			<td class="td-center"><strong>ประเภทผู้แจ้ง</strong></td>
			<td class="td-center"><strong>Ticket No.</strong></td>
			<td class="td-center"><strong>SW Version</strong></td>
			<td class="td-center"><strong>รายละเอียดปัญหา</strong></td>
			<td class="td-center"><strong>บันทึกการแก้ไข</strong></td>
			<td class="td-center"><strong>ผลการแก้ไข</strong></td>
			<td class="td-center"><strong>ส่งต่อ</strong></td>
			<td class="td-center"><strong>บันทึกการแก้ไข</strong></td>
			<td class="td-center"><strong>ผลการแก้ไข</strong></td>
			<td class="td-center"><strong>ส่งต่อ</strong></td>
			<td class="td-center"><strong>บันทึกการแก้ไข</strong></td>
			<td class="td-center"><strong>ผลการแก้ไข</strong></td>
			<td class="td-center"><strong>ส่งต่อ</strong></td>
			<td class="td-center"><strong>วัน - เวลา แก้ไขเสร็จ</strong></td>
			<td class="td-center"><strong>กลุ่มปัญหา</strong></td>
			<td class="td-center"><strong>ระบบงานหลัก</strong></td>
			<td class="td-center"><strong>ระบบงานรอง</strong></td>
			<td class="td-center"><strong>หมายเหตุ</strong></td>
			
		</tr>

		@foreach($jobs as $job)
		<tr>
			<td>{{ $job->created_at }}</td>
			<td>{{ $job->department->name }}</td>
			<td>{{ $job->department->phase }}</td>
			<td>{{ $job->informer_name }}</td>
			<td>{{ $job->informer_phone_number }}</td>
			<td>{{ $job->informer_type=='C' ? 'ลูกค้า' : 'ภายใน (บริษัท)' }}</td>
			<td>{{ $job->ticket_no }}</td>
			<td>{{ $job->sw_version }}</td>
			<td>{{ $job->description }}</td>
			<td>{{ $job->tier1_solve_description }}</td>
			<td>
			@if($job->tier1_solve_result=='0' or $job->tier1_solve_result==0)
				ไม่ได้
			@elseif($job->tier1_solve_result=='1' or $job->tier1_solve_result==1)
				ได้
			@endif
			</td>
			<td>{{ $job->tier1_forward }}</td>
			<td>{{ $job->tier2_solve_description }}</td>
			<td>
			
			@if($job->tier2_solve_result_dtm!=null)
				@if($job->tier2_solve_result=='0' or $job->tier2_solve_result==0)
					ไม่ได้
				@elseif($job->tier2_solve_result=='1' or $job->tier2_solve_result==1)
					ได้
				@endif
			@endif
			</td>
			<td>{{ $job->tier2_forward }}</td>
			<td>{{ $job->tier3_solve_description }}</td>
			<td>
			@if($job->tier3_solve_result_dtm!=null)
				@if($job->tier3_solve_result=='0' or $job->tier3_solve_result==0)
					ไม่ได้
				@elseif($job->tier3_solve_result=='1' or $job->tier3_solve_result==1)
					ได้
				@endif
			@endif
			</td>
			<td>{{ $job->tier3_forward }}</td>
			
			<td>{{ $job->closed_at }}</td>
			<td>{{ $job->call_category ? $job->call_category->problem_group : '' }}</td>
			<td>{{ $job->primary_system ? $job->primary_system->name : '' }}</td>
			<td>{{ $job->secondary_system ? $job->secondary_system->name : '' }}</td>
			<td>{{ $job->remark }}</td>
		</tr>
		@endforeach

</body>
</html>