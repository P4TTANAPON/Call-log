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
                        <div class="col-md-12 col-sm-12">
                            <?php
                            $date = date('d M Y', strtotime($start));
                            if (!($start == $end)) {
                                $date .= ' - ' . date('d M Y', strtotime($end));
                            }
                            ?>
                            <h3 class="page-header">Amount of cases grouping by department ({{ $date }})</h3>
                            <div class="col-md-6">
                                <table class="table-bordered table-condensed table-striped table-custom-pad table">
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
                                                <td><a
                                                        href="{{ url(
                                                            'department?' .
                                                                'fromDate=' .
                                                                Request::get('fromDate') .
                                                                '&toDate=' .
                                                                Request::get('toDate') .
                                                                '&department=' .
                                                                $department->id .
                                                                "&phase=" .
                                                                $department->phase .
                                                                '&page=' .
                                                                Request::get('page'),
                                                        ) }}">
                                                        {{ $department->name }} </a> </td>
                                                <td>DOL {{ $department->phase }}</td>
                                                <td>{{ $department->works }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $departments->appends([
                                        'fromDate' => request()->query('fromDate'),
                                        'toDate' => request()->query('toDate'),
                                        'department' => request()->query('department'),
                                    ])->links() }}
                            </div>
                            <div id="chart-column-div" class="col-md-6" style="height:420px"></div>
                            <?= $lava->render('ColumnChart', 'chartData', 'chart-column-div') ?>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <?php
                            $date = date('d M Y', strtotime($start));
                            if (!($start == $end)) {
                                $date .= ' - ' . date('d M Y', strtotime($end));
                            }
                            ?>
                            <h3 class="page-header">Amount of cases grouping by call-in case - {{ $depName }}</h3>
                            <div class="col-md-6">
                                <table class="table-bordered table-condensed table-striped table-custom-pad table">
                                    <thead>
                                        <tr class="info">
                                            <th>Group of Problem case</th>
                                            <th style="width: 15%">Case</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $job_count = 0; ?>
                                        @foreach ($calls as $call)
                                            @if ($call->works == 0)
                                                @continue
                                            @else
                                                <tr>
                                                    @if (Request::get('department'))
                                                        <?php $depId = Request::get('department'); ?>
                                                    @else
                                                        <?php $depId = $departments[0]->id; ?>
                                                    @endif
                                                    @if ($call->id == 5)
                                                        <td><a
                                                                href="{{ url(
                                                                    'onsite_hw?' .
                                                                        'fromDate=' .
                                                                        $start .
                                                                        '&toDate=' .
                                                                        $end .
                                                                        '&department=' .
                                                                        $depId,
                                                                ) }}">
                                                                {{ $call->problem_group }} </a></td>
                                                    @else
                                                        <td>{{ $call->problem_group }}</td>
                                                    @endif
                                                    <td>{{ $call->works }}</td>
                                                    <?php $job_count += $call->works; ?>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td><strong>{{ $job_count }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="chart-donut-call" class="col-md-6" style="height:420px"></div>
                            <?= $lava->render('DonutChart', 'Call_Category', 'chart-donut-call') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
