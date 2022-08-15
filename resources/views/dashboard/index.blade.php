@extends('layouts.app')

@section('dashboard_active')
    active
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><strong>Dashboard</strong></div>

                    <div class="panel-body">

                        @include('dashboard.filter')

                        <hr/>
                        <div><strong>จำนวนงาน</strong> : {{ $job_count }}</div>

                        <div class="col-md-12 col-sm-12">
                            <h3 class="page-header">Amount of cases grouping by call-in case</h3>
                            <div class="col-md-6">
                                <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                    <thead>
                                    <tr class="info">
                                        <th>Group of Problem case</th>
                                        <th style="width: 15%">Case</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($calls as $call)
                                        @if($call['count'] == 0)
                                            @continue
                                        @else
                                            <tr>
                                                <td>{{$call['name']}}</td>
                                                <td>{{$call['count']}}</td>
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

                        @if (Request::get('project') == 'dol1' || Request::get('project') == 'dol2'
                            || Request::get('project') == 'dol4')
                            <div class="col-md-12 col-sm-12">
                                <h3 class="page-header">Amount of cases defined by application module</h3>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                        <thead>
                                        <tr class="info">
                                            <th>Group of Problem case</th>
                                            <th style="width: 15%">Case</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($systems as $system)
                                            @if($system['count'] == 0)
                                                @continue
                                            @endif
                                            <tr>
                                                <td>@if($system['flag']!="Non App") [{{ $system['flag'] }}] @endif 
                                                    {{ $system['name'] }}</td>
                                                <td>{{ $system['count'] }}</td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td>NON Application</td>
                                            <td>{{ $sumNon }}</td>
                                        </tr> --}}
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td><strong>{{ $sumSys + $sumNon }}</strong></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div id="chart-donut-system" class="col-md-6" style="height:420px"></div>
                                <?= $lava->render('DonutChart', 'System', 'chart-donut-system') ?>
                            </div>
                        @endif

                        <div class="col-md-12">
                            <h3 class="page-header">Workload History of Support Team</h3>
                            <div class="col-md-6">
                                <table class="table table-bordered table-condensed table-striped table-custom-pad">
                                    <thead>
                                    <tr class="info">
                                        <th>Date</th>
                                        <th style="width: 15%">Helpdesk</th>
                                        <th style="width: 15%">Support</th>
                                        <th style="width: 15%">Tier 3</th>
                                        <th style="width: 15%">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($workload as $item)
                                        <tr>
                                            <td>{{ $item['date'] }}</td>
                                            <td>{{ $item['helpdesk'] }}</td>
                                            <td>{{ $item['support'] }}</td>
                                            <td>{{ $item['tier3'] }}</td>
                                            <td><strong>{{ $item['sum']}}</strong></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <p>* Tier 3 = SA + App Server + Network + System + CGC</p>
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
                                        <th class="text-center" style="min-width: 128px; vertical-align: middle"
                                            rowspan="2">Date
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

                        {{-- @if(Request::get('project') == 'all')
                            <div class="col-md-12 col-sm-12">
                                <h3 class="page-header">Call-In History</h3>
                                <div id="chart-line-callin" class="col-md-6" style="height:420px"></div>
                                <= $lava->render('LineChart', 'CallIn', 'chart-line-callin') ?>
                                <div id="chart-pie-callin" class="col-md-6" style="height:420px"></div>
                                <= $lava->render('PieChart', 'CallInPie', 'chart-pie-callin') ?> 
                            </div>
                        @endif --}}

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
