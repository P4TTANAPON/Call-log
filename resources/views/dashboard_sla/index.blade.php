@extends('layouts.app')

@section('dashboard_sla_active')
active
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Dashboard</strong></div>

                <div class="panel-body">

                    @include('dashboard_sla.filter')

                    <hr />
                    <div><strong>จำนวนงาน</strong> : {{ $job_count[0] }}</div>

                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Amount of cases grouping by call-in case</h3>
                        <div class="col-md-6">
                            <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                <thead>
                                    <tr class="info">
                                        <th>Group of Problem case</th>
                                        <th style="width: 15%">Case</th>
                                        <th style="width: 15%">Close</th>
                                        <th style="width: 15%">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $call_sum = 0; ?>
                                    <?php $callclose_sum = 0; ?>
                                    <?php $callAc_sum = 0; ?>
                                    @foreach($calls[0] as $call)
                                    @if($call['count_close'] == 0)
                                    @continue
                                    @else
                                    <?php $callclose_sum += $call['count_close']; ?>
                                    @endif
                                    @endforeach
                                    @foreach($calls[0] as $call)
                                    @if($call['count_active'] == 0)
                                    @continue
                                    @else
                                    <?php $callAc_sum += $call['count_active']; ?>
                                    @endif
                                    @endforeach
                                    @foreach($calls[0] as $call)
                                    @if($call['count'] == 0)
                                    @continue
                                    @else
                                    <?php $call_sum += $call['count']; ?>
                                    @endif
                                    <tr>
                                        <td>{{ $call['problem_group'] }}</td>
                                        <td style="text-align: right;">{{ $call['count'] }}</td>
                                        <td style="text-align: right;">{{ $call['count_close'] }}</td>
                                        <td style="text-align: right;">{{ $call['count_active'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td style="text-align: right;"><strong>{{ $call_sum }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ $callclose_sum }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ $callAc_sum }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        <div id="chart-donut-call" class="col-md-6" style="height:420px"></div>
                        <?= $lava->render('DonutChart', 'Call_Category', 'chart-donut-call') ?>
                    </div>

                    @if (Request::get('project') == 'dol1' || Request::get('project') == 'dol2'
                    || Request::get('project') == 'dol4')
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Amount of cases defined by Problem module</h3>
                        <div class="col-md-6">
                            <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                <thead>
                                    <tr class="info">
                                        <th>Group of Problem case</th>
                                        <th style="width: 15%">Case</th>
                                        <th style="width: 15%">SLA</th>
                                        <th style="width: 15%">Over SLA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $system_sum = 0; ?>
                                    <?php $system_slasum = 0; ?>
                                    <?php $system_overslasum = 0; ?>
                                    @foreach($systems[0] as $system)
                                        @if($system['count'] == 0)
                                            @continue
                                        @else
                                            <?php $system_sum += $system['count']; ?>
                                            @if($system['SLA'] != 0)
                                                <?php $system_slasum += $system['SLA']; ?>
                                            @endif
                                            @if($system['OverSLA'] != 0)
                                                <?php $system_overslasum += $system['OverSLA']; ?>
                                            @endif
                                        @endif                                   
                                    <tr>
                                        <td>[{{ $system['flag'] }}] {{ $system['name'] }}</td>
                                        <td style="text-align: right;">{{ $system['count'] }}</td>
                                        <td style="text-align: right;">{{ $system['SLA'] }}</td>
                                        <td style="text-align: right;">{{ $system['OverSLA'] }}</td>
                                    </tr>
                                    @endforeach
                                    <!-- <tr>
                                            <td>NON Application</td>
                                            <td>{{ $job_count[0]-$system_sum }}</td>
                                        </tr> -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td style="text-align: right;"><strong>{{ $system_sum  }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ $system_slasum  }}</strong></td>
                                        <td style="text-align: right;"><strong>{{ $system_overslasum  }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="chart-donut-system" class="col-md-6" style="height:420px"></div>
                        <?= $lava->render('DonutChart', 'System', 'chart-donut-system') ?>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <h3 class="page-header">Workload History of On Site Service</h3>
                        <div class="col-md-6">
                            <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                <thead>
                                    <tr class="info">
                                        <th style="text-align: center;">Date</th>
                                        <th style="width: 15%; text-align: center;">Case</th>
                                        <th style="width: 15%; text-align: center;">SLA</th>
                                        <th style="width: 15%; text-align: center;">OverSLA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workload as $item)
                                    <tr>
                                        <td>{{ $item['date'] }}</td>
                                        <td style="text-align: right;"><strong>{{ $item['Case'] }}</strong></td>
                                        <td style="text-align: right;">{{ $item['SLA'] }}</td>
                                        <td style="text-align: right;">{{ $item['OverSLA'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- <p>* Tier 3 = SA + App Server + Network + System + CGC</p> -->
                        </div>
                        <div id="chart-line-div" class="col-md-6" style="height:420px"></div>
                        <?= $lava->render('LineChart', 'Workrate', 'chart-line-div') ?>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">History of case grouping by Service Type</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                <thead>
                                    <tr class="info">
                                        <th class="text-center" style="min-width: 128px; vertical-align: middle" rowspan="2">Date
                                        </th>
                                        <th class="text-center" style="background-color: lightsteelblue" colspan="8">
                                            Maintenance Service
                                        </th>
                                        <th class="text-center" style="background-color: sandybrown" colspan="6">
                                            Operation Service
                                        </th>
                                        <th class="text-center" style="background-color: gainsboro" colspan="3">
                                            Undefined
                                        </th>
                                    </tr>
                                    <tr class="info">
                                        <th style="width: 6.2%">Bug</th>
                                        <th style="width: 6.2%">Network /Link</th>
                                        <th style="width: 6.2%">System</th>
                                        <th style="width: 6.2%">Database</th>
                                        <th style="width: 6.2%">On Site Service</th>
                                        <th style="width: 6.2%">App Server</th>
                                        <th style="width: 6.2%">Service Library</th>
                                        <th style="width: 6.2%">Total</th>
                                        <th style="width: 6.2%">Advice</th>
                                        <th style="width: 6.2%">User Error</th>
                                        <th style="width: 6.2%">Data</th>
                                        <th style="width: 6.2%">User's Rights</th>
                                        <th style="width: 6.2%">IT Support</th>
                                        <th style="width: 6.2%">Total</th>
                                        <th style="width: 6.2%">Comment</th>
                                        <th style="width: 6.2%">Other</th>
                                        <th style="width: 6.2%">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($service_type as $item)
                                    <tr>
                                        <td>{{ $item['date'] }}</td>
                                        <td>{{ $item['101'] }}</td>
                                        <td>{{ $item['102'] }}</td>
                                        <td>{{ $item['103'] }}</td>
                                        <td>{{ $item['104'] }}</td>
                                        <td>{{ $item['105'] }}</td>
                                        <td>{{ $item['106'] }}</td>
                                        <td>{{ $item['107'] }}</td>
                                        <td>
                                            <strong>{{ $item['101'] + $item['102'] + $item['103'] + $item['104']
                                                + $item['105'] + $item['106'] + $item['107'] }}</strong>
                                        </td>
                                        <td>{{ $item['201'] }}</td>
                                        <td>{{ $item['202'] }}</td>
                                        <td>{{ $item['203'] }}</td>
                                        <td>{{ $item['204'] }}</td>
                                        <td>{{ $item['205'] }}</td>
                                        <td>
                                            <strong>{{ $item['201'] + $item['202'] + $item['203'] + $item['204']
                                                + $item['205'] }}</strong>
                                        </td>
                                        <td>{{ $item['301'] }}</td>
                                        <td>{{ $item['302'] }}</td>
                                        <td><strong>{{ $item['301'] + $item['302'] }}</strong></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if(Request::get('project') == 'all')
                    <div class="col-md-12 col-sm-12">
                        <h3 class="page-header">Call-In History</h3>
                        <div id="chart-line-callin" class="col-md-6" style="height:420px"></div>
                        <?= $lava->render('LineChart', 'CallIn', 'chart-line-callin') ?>
                        <div id="chart-pie-callin" class="col-md-6" style="height:420px"></div>
                        <?= $lava->render('PieChart', 'CallInPie', 'chart-pie-callin') ?>
                    </div>
                    @endif

                    {{--<div class="col-md-12 col-sm-12">--}}
                    {{--<h3 class="page-header">Call-In History</h3>--}}
                    {{--<div class="col-md-6"></div>--}}
                    {{--<div class="col-md-6"></div>--}}
                    {{--</div>--}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection