@extends('layouts.app')

@section('department_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Dashboard</strong></div>
                <div class="panel-body">
                    @include('department.filter')
                    <hr />
                    {{-- <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div> --}}
                    <div class="col-md-12 col-sm-12">
                        <?php 
                            $date = date('d M Y',strtotime($start));
                            if(!($start==$end)) $date .= ' - '. date('d M Y',strtotime($end));
                        ?>
                        <h3 class="page-header">Amount of cases grouping by department ({{$date}})</h3>
                        <div class="col-md-6">
                            <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                <thead>
                                    <tr class="info">
                                        <th>Department</th>
                                        <th style="width: 15%">Project</th>
                                        <th style="width: 15%">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $department)
                                        <tr>
                                            <td>{{$department->name}}</td>
                                            <td>DOL {{$department->phase}}</td>
                                            <td>{{$department->works}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td style="text-align: right;"><strong>{{ $call_sum }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ $callclose_sum }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ $callAc_sum }}</strong></td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                            {{$departments->appends(['fromDate'=>request()->query('fromDate'),'toDate'=>request()->query('toDate')])->links()}}
                        </div>
                        <div id="chart-column-div" class="col-md-6" style="height:420px"></div>
                        <?= $lava->render('ColumnChart', 'chartData', 'chart-column-div') ?>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection