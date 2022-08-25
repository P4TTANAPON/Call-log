@extends('layouts.app')

@section('onsite_hw_active')
    active
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"><strong>Dashboard</strong></div>
                    <div class="panel-body">
                        @include('onsite_hw.filter')
                        <hr />
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <?php
                                $date = date('d M Y', strtotime($start));
                                if (!($start == $end)) {
                                    $date .= ' - ' . date('d M Y', strtotime($end));
                                }
                                ?>
                                <h3 class="page-header">Amount of hardware grouping by type <br>
                                    <h4> {{ $depName }} {{ $date }} </h4>
                                </h3>

                                <div class="col-md-6">
                                    <table class="table-bordered table-condensed table-striped table-custom-pad table">
                                        <thead>
                                            <tr class="info">
                                                <th>Product</th>
                                                <th style=zzz"width: 15%">Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sum = 0; ?>
                                            @if ($hw->count() > 0)
                                                @foreach ($hw as $item)
                                                    <tr>
                                                        <td><a
                                                                href="{{ url(
                                                                    '/onsite_hw?fromDate=' .
                                                                        Request::get('fromDate') .
                                                                        '&toDate=' .
                                                                        Request::get('toDate') .
                                                                        '&phase=' .
                                                                        Request::get('phase') .
                                                                        '&department=' .
                                                                        Request::get('department') .
                                                                        '&name=' .
                                                                        $item->product .
                                                                        '&hw=' .
                                                                        Request::get('hw') .
                                                                        '&hwDet=1',
                                                                ) }}">
                                                                {{ $item->product }}
                                                            </a></td>
                                                        <td>{{ $item->jobs }}</td>
                                                        <?php $sum += $item->jobs; ?>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><strong>Total</strong></td>
                                                <td><strong>{{ $sum }}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    {{ $hw->appends([
                                            'fromDate' => request()->query('fromDate'),
                                            'toDate' => request()->query('toDate'),
                                            'department' => request()->query('department'),
                                            'phase' => request()->query('phase'),
                                            'name' => request()->query('name'),
                                            'hwDet' => $hwDet->currentPage(),
                                        ])->links() }}
                                </div>
                                <div id="chart-pie-call" class="col-md-6" style="height:420px"></div>
                                <?= $lava->render('PieChart', 'group_hw', 'chart-pie-call') ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h3 class="page-header">Detail of hardware grouping by type - {{ $name }} </h3>
                                <table class="table-bordered table-condensed table-striped table-custom-pad table">
                                    <thead>
                                        <tr class="info">
                                            <th nowrap>No.</th>
                                            <th nowrap style="width: 108px;">Ticket No.</th>
                                            <th nowrap>Product</th>
                                            <th nowrap>Model</th>
                                            <th nowrap>Serial Number</th>
                                            <th nowrap>Department</th>
                                            <th nowrap>Phase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n = 25 * $hwDet->currentPage() - 24; ?>
                                        @foreach ($hwDet as $det)
                                            <tr>
                                                <td>{{ $n++ }}</td>
                                                <td>
                                                    <a href="{{ url('/job/' . $det->id) }}">{{ $det->ticket_no }}</a>
                                                </td>
                                                <td>{{ $det->product }}</td>
                                                <td>{{ $det->model_part_number }}</td>
                                                <td>{{ $det->serial_number }}</td>
                                                <td>{{ $det->departments }}</td>
                                                <td>DOL {{ $det->phase }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $hwDet->appends([
                                        'fromDate' => request()->query('fromDate'),
                                        'toDate' => request()->query('toDate'),
                                        'department' => request()->query('department'),
                                        'phase' => request()->query('phase'),
                                        'name' => request()->query('name'),
                                        'hw' => $hw->currentPage(),
                                    ])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- {{$hw}} --}}
    </div>
@endsection
