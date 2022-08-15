@extends('layouts.app')

@section('about_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">About</div>

                <div class="panel-body">
					<div class="col-md-5">
						<dl class="dl-horizontal">
							<dt>Version</dt>
							<dd>1.0 Beta</dd>
							
							<dt>Dev contact</dt>
							<dd>Email: pkxiii@gmail.com</dd>
							<dd>Line: pkxiii</dd>
						</dl> 
					</div>
					<div class="col-md-7">
						<strong>Software update log</strong>
						<hr/>
						2016-04-18
						<ul>
							<li>minor bug fixes</li>
						</ul>
						2016-04-01 2c6d643
						<ul>
							<li>เพิ่มโครง Dashboard คร่าวๆ</li>
							<li>แก้ bug เล็กน้อย</li>
						</ul>
						2016-03-30 5c7e7b8
						<ul>
							<li>เพิ่ม SA Review เวลาออก Excel</li>
						</ul>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
