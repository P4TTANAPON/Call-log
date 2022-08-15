<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	
	<style>
		.border {
			border-top: 1px solid #000000;
			border-right: 1px solid #000000;
			border-bottom: 1px solid #000000;
			border-left: 1px solid #000000;
		}
	</style>

	<tr>
		<td><strong>Ticket No. : {{ $job->ticket_no }}</strong></td>
		<td><strong>Date : {{ $job->created_at }}</strong></td>
	</tr>
	
	<tr></tr>
	
	<tr>
		<td class="border"><strong>โครงการ</strong></td>
		<td class="border"><strong>หน่วยงาน</strong></td>
		<td class="border"><strong>อุปกรณ์ที่ขัดข้อง</strong></td>
		<td class="border"><strong>รุ่นอุปกรณ์</strong></td>
		<td class="border"><strong>หมายเลขอุปกรณ์</strong></td>
		<td class="border"><strong>อาการขัดข้องของอุปกรณ์ที่พบ</strong></td>
		<td class="border"><strong>ผู้แจ้ง</strong></td>
	</tr>
	
	<tr>
		<td class="border">{{ $job->department->phase }}</td>
		<td class="border">{{ $job->department->name }}</td>
		<td class="border">{{ $scs->product }}</td>
		<td class="border">{{ $scs->model_part_number }}</td>
		<td class="border">{{ $scs->serial_number }}</td>
		<td class="border">{{ $scs->malfunction }}</td>
		<td class="border">{{ $job->informer_name }} / {{ $job->informer_phone_number }}</td>
	</tr>
	
	<tr></tr>
	
	<tr><td><strong>การดำเนินการของ SCS</strong></td></tr>
	
	<tr></tr>
	
	<tr>
		<td class="border"><strong>วัน - เวลาที่เข้าแก้ไข</strong></td>
		<td class="border"><strong>วัน - เวลาที่แก้ไขเสร็จ</strong></td>
		<td class="border"><strong>สาเหตุของปัญหา</strong></td>
		<td class="border"><strong>รายละเอียดการแก้ไข</strong></td>
		<td class="border"><strong>ชื่อลูกค้ารับคืนดี/เบอร์โทรศัพท์</strong></td>
		<td class="border"><strong>หมายเหตุ</strong></td>
	</tr>
	
	<tr>
		<td class="border"></td>
		<td class="border">{{ $scs->action_dtm }}</td>
		<td class="border">{{ $scs->cause }}</td>
		<td class="border">{{ $scs->action }}</td>
		<td class="border">{{ $job->informer_name }} / {{ $job->informer_phone_number }}</td>
		<td class="border">{{ $scs->remark }}</td>
	</tr>
	
</body>
</html>