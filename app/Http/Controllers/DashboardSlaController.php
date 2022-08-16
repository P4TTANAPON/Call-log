<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Job;
use App\CallCategory;
use App\System;
use DB;
use Mail;
use Excel;
use Khill\Lavacharts\Lavacharts;

class DashboardSlaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->user()->team == 'DOL') {
            return redirect('/job');
        }

        if (!($request->get('groupby') && $request->get('project') && ($request->get('week') || $request->get('month') || $request->get('fromDate')))) 
        {
            return redirect('/dashboard_sla?groupby=week&year='. date('Y') .'&week='. date('W') .'&project=all');
        }

        // week
        // ?year=2016&groupby=week&week=22&project=all
        // 22 => 'May 30, 2016 - June 5, 2016',

        // month
        // ?year=2016&groupby=month&month=5&project=all
        // 5 => 'May',

        $diff = 0;
        if($request->get('groupby')=='duration'){
            $diff = date_diff(date_create($request->get('fromDate')),date_create($request->get('toDate')),true)
                ->format('%a');
        }

        if ($request->get('groupby') == 'day' || ($request->get('groupby') == 'duration' && $diff < 7)) $lookBack = 7;
        else if($request->get('groupby') == 'week' || ($request->get('groupby') == 'duration' && $diff < 15)) $lookBack = 8;
        elseif ($request->get('groupby') == 'month' || ($request->get('groupby') == 'duration' && $diff >= 15)) $lookBack = 5;
        else return redirect('/dashboard');

        $jobs = [];
        $reqYear = $request->get('year');
        $reqWeek = $request->get('week');
        $reqMonth = $request->get('month');
        $reqDay = $request->get('fromDate');
        if($request->get('groupby') == 'duration'){
            $reqDay = $request->get('toDate');
            $selDate = date_create($request->get('toDate'));
            $reqWeek = $selDate->format("W");
            $reqMonth = $selDate->format("m");
            $reqYear = $selDate->format("Y");
        }

        for($i = 0; $i < $lookBack; $i++) {
            if ($request->get('groupby') == 'day' || ($request->get('groupby') == 'duration' && $diff < 7)){
                $startDate = strtotime("- ".$i."day", strtotime($reqDay));
                $jobs[$i] = Job::whereBetween('created_at', [date('Y-m-d 00:00:00', $startDate), date('Y-m-d 23:59:59', $startDate)]);
            } elseif ($request->get('groupby') == 'week' || ($request->get('groupby') == 'duration' && $diff < 15)) {
                if($reqWeek-$i == 0) {
                    $reqYear = $reqYear-1;
                    $reqWeek = 52 + $i;
                }
                if ($reqYear == '2016') {
                    $startDate = strtotime(explode(' - ', config('app.week_of_year_2016')[$reqWeek-$i])[0] . ', ' . $reqYear);
                    $endDate = strtotime(explode(' - ', config('app.week_of_year_2016')[$reqWeek-$i])[1] . ', ' . $reqYear);
                } elseif ($reqYear == '2017') {
                    $startDate = strtotime(explode(' - ', config('app.week_of_year_2017')[$reqWeek-$i])[0] . ', ' . $reqYear);
                    $endDate = strtotime(explode(' - ', config('app.week_of_year_2017')[$reqWeek-$i])[1] . ', ' . $reqYear);
                } elseif ($reqYear == '2019') {
                    $startDate = strtotime(explode(' - ', config('app.week_of_year_2019')[$reqWeek-$i])[0] . ', ' . $reqYear);
                    $endDate = strtotime(explode(' - ', config('app.week_of_year_2019')[$reqWeek-$i])[1] . ', ' . $reqYear);
                } elseif ($reqYear == '2020') {
                    $startDate = strtotime(explode(' - ', config('app.week_of_year_2020')[$reqWeek-$i])[0] . ', ' . $reqYear);
                    $endDate = strtotime(explode(' - ', config('app.week_of_year_2020')[$reqWeek-$i])[1] . ', ' . $reqYear);
                } elseif ($reqYear == '2021') {
                    $startDate = strtotime(explode(' - ', config('app.week_of_year_2021')[$reqWeek-$i])[0] . ', ' . $reqYear);
                    $endDate = strtotime(explode(' - ', config('app.week_of_year_2021')[$reqWeek-$i])[1] . ', ' . $reqYear);
                } elseif ($reqYear == '2022') {
                    $startDate = strtotime(explode(' - ', config('app.week_of_year_2022')[$reqWeek-$i])[0] . ', ' . $reqYear);
                    $endDate = strtotime(explode(' - ', config('app.week_of_year_2022')[$reqWeek-$i])[1] . ', ' . $reqYear);
                }
                $jobs[$i] = Job::whereBetween('created_at', [date('Y-m-d', $startDate), date('Y-m-d', $endDate)]);
            } elseif ($request->get('groupby') == 'month' || ($request->get('groupby') == 'duration' && $diff >= 15)) {
                $monthNumber = $reqMonth - $i;
                
                if ($monthNumber < 1) {
                    $monthNumber += 12;
                    $reqYear = $reqYear - 1;
                }
                //echo '-' . $monthNumber . ' : ' . $reqYear;
                $month = strtotime(config('app.month_of_year')[$monthNumber] . ' ' . $reqYear);
                //echo ' : '. date('Y-m-d 00:00:00', $month) . ' - ' . date('Y-m-t 23:59:59', $month);
                $jobs[$i] = Job::whereBetween('created_at', [date('Y-m-d 00:00:00', $month), date('Y-m-t 23:59:59', $month)]);
            }

            if ($request->get('project') == 'dol1') $jobs[$i] = $jobs[$i]->where('phase', '1');
            elseif ($request->get('project') == 'dol2') $jobs[$i] = $jobs[$i]->where('phase', '2');
            elseif ($request->get('project') == 'dol4') $jobs[$i] = $jobs[$i]->where('phase', '4');

            $jobs[$i] = $jobs[$i]->get();
        }

        // TODO

        $job_count = $calls = $workload = $service_type = $call_in = $systems = [];
        $reqYear = $request->get('year');
        $reqWeek = $request->get('week');
        $reqMonth = $request->get('month');
        $reqDay = $request->get('fromDate');

        if($request->get('groupby') == 'duration'){
            $reqDay = $request->get('toDate');
            $selDate = date_create($request->get('toDate'));
            $reqWeek = $selDate->format("W");
            $reqMonth = $selDate->format("m");
            $reqYear = $selDate->format("Y");
        }

        for($week = 0; $week < $lookBack; $week++) {
            $calls[$week] = CallCategory::all()->toArray();
            for ($i = 0; $i < count($calls[$week]); $i++) {
                $calls[$week][$i]['count'] = 0;
                $calls[$week][$i]['count_close'] = 0;
                $calls[$week][$i]['count_active'] = 0;   
            }
            //$workload[$week] = ['date' => '', 'cc' => 0, 'sp' => 0, 'sa' => 0, 'nw' => 0, 'st' => 0, 'scs' => 0];
            $workload[$week] = ['date' => '', 'Case' => 0, 'SLA' => 0, 'OverSLA' => 0];
            $service_type[$week] = [
                'date' => '', '101' => 0, '102' => 0, '103' => 0, '104' => 0, '105' => 0, '201' => 0, '202' => 0,
                '203' => 0, '204' => 0, '205' => 0, '301' => 0, '302' => 0, '106' => 0, '107' => 0
            ];
            $call_in[$week] = ['date' => '', 'dol1' => 0, 'dol2' => 0, 'dol4' => 0];
            if($request->get('project') == 'dol1' || $request->get('project') == 'dol2' || $request->get('project') == 'dol4')
            {
                //$systems[$week] = System::where('phase', str_replace('dol', '', $request->get('project'))) ->get()->toArray();
                //echo System::where('phase', str_replace('dol', '', $request->get('project'))) ->get();
                //echo '-' . count($systems[$week]);
                //$systems[$week] =["name"=>"Windows Problems","flag"=>"Clone"];
                $systems[$week] = [
                    [
                        "id" => "1",
                        "name" => "Windows Problems",
                        "flag" => "Clone",
                        "sla" => "0",
                        "oversla" => "0"
                    ],
                    [
                        "id" => "2",
                        "name" => "Hardware Problems",
                        "flag" => "HW",
                        "sla" => "0",
                        "oversla" => "0"
                    ],
                    [
                        "id" => "3",
                        "name" => "อุปกรณ์ชนิดอื่น",
                        "flag" => "e.g.",
                        "sla" => "0",
                        "oversla" => "0"
                    ]
                ];

                for ($i = 0; $i < count($systems[$week]); $i++) {
                    $systems[$week][$i]['count'] = 0;
                    $systems[$week][$i]['SLA'] = 0;
                    $systems[$week][$i]['OverSLA'] = 0;
                }
            }

            if ($request->get('groupby') == 'day' || ($request->get('groupby') == 'duration' && $diff < 7)){
                $workload[$week]['date']
                = $service_type[$week]['date']
                = $call_in[$week]['date']
                = date('d M Y',strtotime('-'.$week.'day',strtotime($reqDay)));
                // echo date('d M Y',strtotime('-'.$week.'day',strtotime($reqDay))).'<br>';
            } elseif ($request->get('groupby') == 'week' || ($request->get('groupby') == 'duration' && $diff < 15)) {
                if($reqWeek-$week == 0) {
                    $reqYear = $reqYear-1;
                    $reqWeek = 52 + $week;
                }
                $workload[$week]['date']
                = $service_type[$week]['date']
                = $call_in[$week]['date']
                = $job_count[$week]['date']
                = config('app.week_of_year_'. $reqYear)[$reqWeek - $week];
            } elseif ($request->get('groupby') == 'month' || ($request->get('groupby') == 'duration' && $diff >= 15)) {
                if ($reqMonth - $week < 1) {
                    $reqMonth += 12;
                    $reqYear -= 1;
                }
                $workload[$week]['date']
                = $service_type[$week]['date']
                = $call_in[$week]['date']
                = $job_count[$week]['date']
                = config('app.month_of_year')[$reqMonth - $week] . ' ' . $reqYear;
            }

            $job_count[$week] = count($jobs[$week]);
            $typeSystem = array('windows', 'จอฟ้า', 'สีฟ้า', 'repair', 'automatic', 'โคลน', 'clone', 'restart');
            $typeHW = array('จอดับ', 'จอดำ', 'กระพริบ','ไม่ติด','hdmi','usb');
            foreach ($jobs[$week] as $job) {
                // $calls
                if ($job->sa_rw_call_category_id) {
                    for ($i = 0; $i < count($calls[$week]); $i++) {
                        if ($calls[$week][$i]['id'] == $job->sa_rw_call_category_id) {
                            $calls[$week][$i]['count']++;
                            $service_type[$week][$calls[$week][$i]['code']]++; // $service_type
                            if ($job-> closed != 1){
                                $calls[$week][$i]['count_active']++;
                            }else{
                                $calls[$week][$i]['count_close']++;
                            }
                            break;
                        }
                    }
                } elseif ($job->call_category_id) {
                    for ($i = 0; $i < count($calls[$week]); $i++) {
                        if ($calls[$week][$i]['id'] == $job->call_category_id) {
                            $calls[$week][$i]['count']++;
                            $service_type[$week][$calls[$week][$i]['code']]++; // $service_type
                            if ($job-> closed != 1){
                                $calls[$week][$i]['count_active']++;
                            }else{
                                 $calls[$week][$i]['count_close']++;
                            }
                            break;
                        }
                    }
                }

                // $workload on site service [Case, SLA, OverSLA]
                if ($job->call_category_id == '5') {
                    $workload[$week]['Case']++;
                    $SLACount = $job->SLACount();
                    if ($SLACount['p'] >= 100){
                        $workload[$week]['OverSLA']++;
                    }else{
                        $workload[$week]['SLA']++;
                    }
                }
                // if ($job->tier1_solve_result) {
                //     $workload[$week]['cc']++;
                // } elseif ($job->tier2_solve_result) {
                //     $workload[$week]['sp']++;
                // } elseif ($job->tier3_solve_result) {
                //     if ($job->last_operator_team == 'SA') $workload[$week]['sa']++;
                //     elseif ($job->last_operator_team == 'NW') $workload[$week]['nw']++;
                //     elseif ($job->last_operator_team == 'ST') $workload[$week]['st']++;
                // } elseif ($job->scs_solve_result_dtm) {
                //     $workload[$week]['scs']++;
                // }

                // $call_in
                if($request->get('project') == 'all') {
                    if ($job->phase == '1') $call_in[$week]['dol1']++;
                    elseif ($job->phase == '2') $call_in[$week]['dol2']++;
                    elseif ($job->phase == '4') $call_in[$week]['dol4']++;
                }

                // $systems
                if($request->get('project') == 'dol1' || $request->get('project') == 'dol2' || $request->get('project') == 'dol4')
                {
                    if ($job->call_category_id == '5'){
                        $SLACount = $job->SLACount();
                        if ($this->strposa(strtolower($job->description), $typeSystem, 1)){

                            if ($SLACount['p'] >= 100){
                                $systems[$week][0]['OverSLA']++;
                            }else{
                                $systems[$week][0]['SLA']++;
                            }
                            $systems[$week][0]['count']++;
                        }else{

                            
                            if($this->strposa(strtolower($job->description), $typeHW, 1))
                            {
                                if ($SLACount['p'] >= 100){
                                    $systems[$week][1]['OverSLA']++;
                                }else{
                                    $systems[$week][1]['SLA']++;
                                }
                                $systems[$week][1]['count']++;
                            }else{
                                if ($SLACount['p'] >= 100){
                                    $systems[$week][2]['OverSLA']++;
                                }else{
                                    $systems[$week][2]['SLA']++;
                                }
                                $systems[$week][2]['count']++;
                            }

                           
                        }
                        

                    }
                    // for ($i = 0; $i < count($systems[$week]); $i++) {
                    //     if ($systems[$week][$i]['id'] == $job->sa_rw_primary_system_id) {
                    //         $systems[$week][$i]['count']++;
                    //         break;
                    //     } elseif ($systems[$week][$i]['id'] == $job->primary_system_id) {
                    //         $systems[$week][$i]['count']++;
                    //         break;
                    //     }
                    // }
                }
            }

            // sort
            $calls[$week] = array_reverse(array_sort($calls[$week], function ($value) {
                return $value['count'];
            }));

            if($request->get('project') == 'dol1' || $request->get('project') == 'dol2' || $request->get('project') == 'dol4')
            {
                $systems[$week] = array_reverse(array_sort($systems[$week], function ($value) {
                    return $value['count'];
                }));
            }
        }

        /*
         * start Lavacharts
         */
        $lava = new Lavacharts;

        // Amount of cases grouping by call-in case
        $group_call = $lava->DataTable();
        $group_call->addStringColumn('Problem')->addNumberColumn('Jobs');

        foreach ($calls[0] as $call) {
            $group_call->addRow([$call['problem_group'], $call['count']]);
        }

        $lava->DonutChart('Call_Category', $group_call, [
            'legend' => [
                'position' => 'left'
            ],
            'chartArea' => [
                'top' => 5,
                'left' => 0,
                'width' => '100%',
                'height' => 320
            ]
        ]);

        if($request->get('project') == 'dol1' || $request->get('project') == 'dol2' || $request->get('project') == 'dol4') {
            // Amount of cases defined by application module
            $systemDataTable = $lava->DataTable();
            $systemDataTable->addStringColumn('System')->addNumberColumn('Jobs');

            foreach ($systems[0] as $system) {
                $systemDataTable->addRow([$system['flag'], $system['count']]);
            }

            $lava->DonutChart('System', $systemDataTable, [
                'legend' => [
                    'position' => 'left'
                ],
                'chartArea' => [
                    'top' => 5,
                    'left' => 0,
                    'width' => '100%',
                    'height' => 320
                ]
            ]);
        }
        
        // Workload History of Support Team
        $workrate = $lava->Datatable();
        $workrate->addStringColumn('Date')
            ->addNumberColumn('Case')
            ->addNumberColumn('SLA')
            ->addNumberColumn('OverSLA');

        // if (date('Y') == '2016') {
            for($week = $lookBack-1; $week >= 0; $week--) {
                $workrate->addRow([$workload[$week]['date'],
                    $workload[$week]['Case'],
                    $workload[$week]['SLA'],
                    $workload[$week]['OverSLA']
                ]);
            }
        // }

        $lava->LineChart('Workrate', $workrate, [
            'interpolateNulls' => false,
            'legend' => [
                'position' => 'top'
            ],
            'pointSize' => 5,
            'chartArea' => [
                'left' => 25,
                'width' => '100%',
                'height' => 320
            ]
        ]);

        // Call-In History - line
        $callInData = $lava->Datatable();
        $callInData->addStringColumn('Date')
            ->addNumberColumn('DOL1')
            ->addNumberColumn('DOL2')
            ->addNumberColumn('DOL4');

        // if (date('Y') == '2016') {
            for($week = $lookBack-1; $week >= 0; $week--) {
                $callInData->addRow([$call_in[$week]['date'],
                    $call_in[$week]['dol1'],
                    $call_in[$week]['dol2'],
                    $call_in[$week]['dol4']
                ]);
            }
        // }

        $lava->LineChart('CallIn', $callInData, [
            'interpolateNulls' => false,
            'legend' => [
                'position' => 'top'
            ],
            'pointSize' => 5,
            'chartArea' => [
                'left' => 25,
                'width' => '100%',
                'height' => 320
            ]
        ]);

        // Call-In History - pie
        $callInDataPie = $lava->DataTable();

        $callInDataPie->addStringColumn('Project')
            ->addNumberColumn('Count');

        $callInDataPie->addRow(['DOL1', $call_in[0]['dol1']])
            ->addRow(['DOL2', $call_in[0]['dol2']])
            ->addRow(['DOL4', $call_in[0]['dol4']]);

        $lava->PieChart('CallInPie', $callInDataPie, [
            'is3D'   => true,
            'legend' => [
                'position' => 'bottom'
            ],
            'chartArea' => [
                'top' => 40,
                'left' => 0,
                'width' => '100%',
                'height' => 320
            ]
        ]);

        //////////////////////////////////////

        $request->flash();
        return view('dashboard_sla.index', [
            'jobs' => $jobs,
            'job_count' => $job_count,
            'lava' => $lava,
            'calls' => $calls,
            'workload' => $workload,
            'service_type' => $service_type,
            'call_in' => $call_in,
            'systems' => $systems,
            'call_categories' => CallCategory::orderBy('code')->get(),
        ]);
    }

    private function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();
        foreach($needles as $needle) {
                $res = strpos($haystack, $needle, $offset);
                if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        return min($chr);
    }

}
