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
use DateTime;
use Khill\Lavacharts\Lavacharts;

class DashboardController extends Controller
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

        if (!($request->get('groupby') && $request->get('project') && 
            ($request->get('week') || $request->get('month') || $request->get('fromDate')))
        ) {
            return redirect('/dashboard?groupby=week&year='. date('Y') .'&week='. date('W') .'&project=all');
        }

        // week
        // ?year=2016&groupby=week&week=22&project=all
        // 22 => 'May 30, 2016 - June 5, 2016',

        // month
        // ?year=2016&groupby=month&month=5&project=all
        // 5 => 'May',

        $systems = [];

        $phase = $this->checkPhase($request->get('project'));
        if($phase!=0){
            $sys = $this->appModule($request);
        } else {
            $sumSys = 0;
            $sumNon = 0;
        }
        
        $lookBack = $this->lookback($request);
        $date = $this->rangeDate($request,$lookBack);
        
        $cc = $this->callInCase($request);
        $job_count = $cc['sum'];
        $calls = $cc['data'];
        usort($calls, function ($item1, $item2) {
            return $item2['count'] <=> $item1['count'];
        });

        $workload = $this->workloadHistory($request);
        if($phase!=0){
            $systems = $sys['systems'];
            usort($systems, function ($item1, $item2) {
                return $item2['count'] <=> $item1['count'];
            });
            $sumSys = $sys['sumSys'];
            $sumNon = $sys['sumNon'];
        }

        $service_type = $this->serviceTypeHistory($request);
        // echo json_encode( $workload, JSON_UNESCAPED_UNICODE );
        /*
         * start Lavacharts
         */
        $lava = new Lavacharts;

        // Amount of cases grouping by call-in case
        $group_call = $lava->DataTable();
        $group_call->addStringColumn('Problem')->addNumberColumn('Jobs');

        foreach ($calls as $call) {
            $group_call->addRow([$call['name'], $call['count']]);
        }

        $lava->DonutChart('Call_Category', $group_call, [
            'legend' => [
                'position' => 'left',
                // 'textStyle' => [
                //     'fontSize' => 12
                // ]
            ],
            'chartArea' => [
                'top' => 5,
                'left' => 0,
                'width' => '100%',
                'height' => 320
            ]
        ]);

        if($phase!=0) {
            // Amount of cases defined by application module
            $systemDataTable = $lava->DataTable();
            $systemDataTable->addStringColumn('System')->addNumberColumn('Jobs');

            foreach ($systems as $system) {
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
            ->addNumberColumn('Helpdesk')
            ->addNumberColumn('Support')
            ->addNumberColumn('Tier 3');

        // if (date('Y') == '2016') {
            for($week = $lookBack-1; $week >= 0; $week--) {
                $workrate->addRow([$workload[$week]['date'],
                    $workload[$week]['helpdesk'],
                    $workload[$week]['support'],
                    $workload[$week]['tier3']
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

        //////////////////////////////////////

        $request->flash();
        return view('dashboard.index', [
            // 'jobs' => $jobs,
            'job_count' => $job_count,
            'lava' => $lava,
            'calls' => $calls,
            'workload' => $workload,
            'service_type' => $service_type,
            // 'call_in' => $call_in,
            'systems' => $systems,
            'sumSys' => $sumSys,
            'sumNon' => $sumNon,
            //'call_categories' => CallCategory::orderBy('code')->get(),
            'date' => $date,
        ]);
    }

    public function callInCase(Request $request){
        $callType = CallCategory::orderBy('code')->get();
        $callIn = [];
        $sum_call = 0;

        $phase = $this->checkPhase($request->get('project'));
        $lookBack = $this->lookback($request);

        $date = $this->rangeDate($request,$lookBack);
        $startDate = $date['startDate'];
        $endDate = $date['endDate'];

        foreach($callType as $type){
            $call = [];
            $id = $type->id;
            $call['id'] = $id;
            $call['name'] = $type->problem_group;
            $call['count'] = Job::where(function($query) use ($startDate,$endDate,$phase,$id){
                                    $query->whereBetween('created_at', [$startDate, $endDate])
                                        ->whereRaw('IFNULL(sa_rw_call_category_id,call_category_id) = '.$id);
                                    if($phase!=0)
                                        $query->where('phase','=',$phase);
                                })->count();
                        
            $sum_call += $call['count'];
            $callIn[] = $call;
        }
        return ['data'=> $callIn,
                'sum' => $sum_call];
    }

    public function appModule(Request $request){
        $system = System::all();
        $sumSys = 0;
        $sumNon = 0;
        $app = [];

        $reqDepartment = $request->get('department');

        $phase = $this->checkPhase($request->get('project'));
        $lookBack = $this->lookback($request);

        $date = $this->rangeDate($request,$lookBack);
        $startDate = $date['startDate'];
        $endDate = $date['endDate'];

        foreach($system as $sys){
            $data = [];
            $id = $sys->id;
            $data['id'] = $id;
            $data['flag'] = $sys->flag;
            $data['name'] = $sys->name;
            $data['count'] = Job::where(function($query) use ($startDate,$endDate,$phase,$id){
                                $query->whereBetween('created_at', [$startDate, $endDate])
                                    ->whereRaw('IFNULL(sa_rw_primary_system_id,primary_system_id) = '.$id);
                                if($phase!=0)
                                    $query->where('phase','=',$phase);
                            })->count();
            $sumSys += $data['count'];
            $app[] = $data;
        }
            $data = [];
            $data['id'] = 0;
            $data['flag'] = 'Non App';
            $data['name'] = "NON Application";
            $data['count'] = Job::where(function($query) use ($startDate,$endDate,$phase){
                                    $query->whereBetween('created_at', [$startDate, $endDate])
                                        ->whereNull('sa_rw_primary_system_id')
                                        ->whereNull('primary_system_id');
                                    if($phase!=0)
                                        $query->where('phase','=',$phase);
                                })->count();
            $sumNon += $data['count'];
            $app[] = $data;

            return[
                'systems' => $app,
                'sumSys' => $sumSys,
                'sumNon' => $sumNon
            ];

    }

    public function workloadHistory(Request $request){
        $reqProject = $request->get('project');
        $reqDepartment = $request->get('department');

        $phase = $this->checkPhase($request->get('project'));
        $lookBack = $this->lookback($request);

        $workload = [];
        for($i=0; $i<$lookBack; $i++){
            $date = $this->rangeDate($request,$lookBack,$i);
            $startDate = $date['startDate'];
            $endDate = $date['endDate'];
            $dateTxt = $date['dateTxt'];

            $helpdesk = Job::where(function($query) use ($startDate,$endDate,$phase){
                            $query-> whereBetween('created_at', [$startDate, $endDate])
                                ->where('tier1_solve_result','=',1);
                            if($phase!=0)
                                $query->where('phase','=',$phase);
                        })->count();
            $support = Job::where(function($query) use ($startDate,$endDate,$phase){
                            $query->whereBetween('created_at', [$startDate, $endDate])
                                ->where('tier2_solve_result','=',1);
                            if($phase!=0)
                                $query->where('phase','=',$phase);
                        })->count();
            $tier3 = Job::where(function($query) use ($startDate,$endDate,$phase){
                            $query->whereBetween('created_at', [$startDate, $endDate])
                                ->where(function($query){
                                    $query-> where('tier3_solve_result','=',1)
                                        ->orWhereNotNull('scs_solve_result_dtm');
                                });
                            if($phase!=0)
                                $query->where('phase','=',$phase);
                        })->count();
            $data = [];
            $data['date'] = $dateTxt;
            $data['helpdesk'] = $helpdesk;
            $data['support'] = $support;
            $data['tier3'] = $tier3;
            $data['sum'] = $helpdesk+$support+$tier3;
            $workload[] = $data;
        }
        return $workload;
    }

    public function serviceTypeHistory(Request $request){
        $reqDepartment = $request->get('department');

        $callType = CallCategory::orderBy('code')->get();

        $phase = $this->checkPhase($request->get('project'));
        $lookBack = $this->lookback($request);

        $workload = [];
        $service_type = [];
        for($i=0; $i<$lookBack; $i++){
            $date = $this->rangeDate($request,$lookBack,$i);
            $startDate = $date['startDate'];
            $endDate = $date['endDate'];
            $dateTxt = $date['dateTxt'];

            $call = [];
            $call['date'] = $dateTxt;
            foreach($callType as $type){
                $id = $type->id;
                $call[$type->code] = Job::where(function($query) use ($startDate,$endDate,$phase,$id){
                                        $query->whereBetween('created_at', [$startDate, $endDate])
                                            ->whereRaw('IFNULL(sa_rw_call_category_id,call_category_id) = '.$id);
                                        if($phase!=0)
                                            $query->where('phase','=',$phase);
                                    })->count();
            }
            $service_type[] = $call;

        }
        return $service_type;
    }

    private function lookback(Request $request){
        $diff = 0;
        if($request->get('groupby')=='duration'){
            $diff = date_diff(date_create($request->get('fromDate')),date_create($request->get('toDate')),true)
                ->format('%a');
        }

        if ($request->get('groupby') == 'day' || ($request->get('groupby') == 'duration' && $diff < 7)) 
            return 7;
        else if($request->get('groupby') == 'week' || ($request->get('groupby') == 'duration' && $diff < 15)) 
            return 8;
        elseif ($request->get('groupby') == 'month' || ($request->get('groupby') == 'duration' && $diff >= 15)) 
            return 5;
    }

    private function rangeDate(Request $request,$lookBack,$i=0){
        $reqGroup = $request->get('groupby');
        $reqDay = $reqGroup=='duration'? $request->get('fromDate') : $request->get('fromDate');
        $reqWeek = $reqGroup=='duration'? date_create($request->get('toDate'))->format("W") : $request->get('week');
        $reqMonth = $reqGroup=='duration'? date_create($request->get('toDate'))->format("m") : $request->get('month');
        $reqYear = $reqGroup=='duration'? date_create($request->get('toDate'))->format("Y") : $request->get('year');

        if($lookBack==7){
            $startDate = date('Y-m-d 00:00:00',strtotime($reqDay.' -'.$i.' Days'));
            $endDate = date('Y-m-d 23:59:59',strtotime($reqDay.' -'.$i.' Days'));

            $dateTxt = date('d F Y',strtotime($reqDay.' -'.$i.' Days'));
        } elseif ($lookBack == 8){
            if($reqWeek - $i == 0){
                $reqYear -= 1;
                $reqWeek = 52+$i;
            }
            $d = new DateTime;
            $d->setISODate($reqYear,($reqWeek-$i));
            $startDate = $d->format('Y-m-d 00:00:00');
            $endDate = date('Y-m-d 23:59:59',strtotime($startDate. " +6 days"));

            $dateTxt = $d->format('d F');
            $dateTxt .= ' - ';
            $dateTxt .= date('d F',strtotime($startDate. " +6 days"));
        } elseif($lookBack == 5 ){
            if($reqMonth - $i == 0){
                $reqYear -= 1;
                $reqMonth = 12+$i;
            } 
            $startDate = date('Y-m-d 00:00:00',strtotime($reqYear.'-'.($reqMonth-$i)));
            $endDate = date('Y-m-t 23:59:59',strtotime($reqYear.'-'.($reqMonth-$i)));

            $dateTxt =  date('F Y',strtotime($reqYear.'-'.($reqMonth-$i)));
        } 

        return ['startDate'=>$startDate,
                'endDate'=>$endDate,
                'dateTxt'=>$dateTxt,];
    }

    private function checkPhase($reqProject){
        $project = array('dol1','dol2','dol4');
        if(in_array($reqProject,$project))
            return str_replace('dol', '', $reqProject);
        else 
            return 0;
    }
}
