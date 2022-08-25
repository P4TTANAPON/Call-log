<?php

namespace App\Http\Controllers;

use App\Ph1HardwareItem;
use App\Ph2HardwareItem;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Department;
use App\CallCategory;
use App\System;
use App\Job;
use App\Http\Requests\JobRequest;
use App\Operator;
use App\Informer;
use App\ScsJob;
use App\JobStack;
use App\User;
use App\HardwareItem;
use App\SolveDescription;
use App\Traits\queryAlmostDataTrait;
use App\Traits\dateDiffTrait;

use DB;
use Mail;
use Excel;
use Carbon\Carbon;
use Khill\Lavacharts\Lavacharts;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    use queryAlmostDataTrait;
    public function index(Request $request)
    {
        if (($request->get('job') == 'closed' or $request->get('job') == 'all')
            and (empty($request->get('from')) and empty($request->get('to')))
        ) {
            $first_day = date('Y-m-d', strtotime('first day of this month'));
            $last_day = date('Y-m-d', strtotime('last day of this month'));

            return redirect('/job?from=' . $first_day . '&to=' . $last_day . '&job=' . $request->get('job')
                . '&team=' . $request->get('team') . '&ticket=' . $request->get('ticket') . '&active_user=' . $request->get('active_user')
                . '&project=' . $request->get('project') . '&system=' . $request->get('system')
                . '&department=' . $request->get('department') . '&call_category=' . $request->get('call_category')
                . '&description=' . $request->get('description') . '&informer_name=' . $request->get('informer_name')
                . '&informer_phone_number' . $request->get('informer_phone_number'));
        }

        $jobs = $this->queryData($request);
        $jobs = $jobs->orderBy('created_at', 'desc') ->paginate(100);

        $cAlmostIn = $this->queryDataAlmost($request->get('department'),$request->get('project'),0)->count();
        $cAlmostEnd = $this->queryDataAlmost($request->get('department'),$request->get('project'),1)->count();

        return view('job.index', [
            'jobs' => $jobs,
            'departments' => Department::all(),
            'users' => User::where('deleted_at', '=', null) ->get(),
            'call_categories' => CallCategory::orderBy('code')->get(),
            'cAlmostIn' => $cAlmostIn,
            'cAlmostEnd' => $cAlmostEnd,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->user()->team != 'OBS' and $request->user()->team != 'CC' and $request->user()->team != 'DOL') abort(404); //ROOT

        return view('job.create', [
            'informers' => Informer::orderBy('name')->orderBy('phone_number')->get(),
            'departments' => Department::all(),
            'call_categories' => CallCategory::orderBy('code')->get(),
            'systems_ph1' => System::where('phase', 1)->orderBy('flag')->get(),
            'systems_ph2' => System::where('phase', 2)->orderBy('flag')->get(),
            'systems_ph3' => System::where('phase', 3)->orderBy('flag')->get(),
            'systems_ph4' => System::where('phase', 4)->orderBy('flag')->get(),
        ]);
    }

    public function store(JobRequest $request)
    {
        if ($request->user()->team != 'CC' and $request->user()->team != 'DOL') abort(404);

        $job = new Job;
        $job->create_user_id = $request->user()->id;
        $job->ticket_no = $request->user()->code_name . date("ymdHis");
        $job = $this->saveDataCC($request, $job);
        $job->save();

        $jobStack = new JobStack;
        $jobStack->job_id = $job->id;
        $jobStack->stack_number = 1;
        $jobStack->user_team = $request->user()->team;
        $jobStack->user_id = $request->user()->id;
        $jobStack->save();

        if ($request->get('tier1_forward') == 'SCS' || $job->call_category_id == '5') {
            $job->active_operator_id = $request->user()->id;
            $job->save();
            return redirect('/job/' . $job->id . '/edit');
        } else {
            return redirect('/job')->with('success', 'Job created.');
        }
    }

    public function show(Request $request, Job $job)
    {
        if ($request->user()->team == 'SCS') {
            if (!$job->scsjob) {
                abort(401);
            }
        }

        $canEdit = $this->editAuth($request, $job);

        if ($canEdit or $request->user()->team == 'OBS') { //ROOT
            return redirect('job/' . $job->id . '/edit');
        } else {
            if ($this->showAuth($request, $job)) {
                if ($request->user()->team == 'SA') {
                    return view('job.show.index', [
                        'job' => $job,
                        'call_categories' => CallCategory::orderBy('code')->get(),
                        'systems' => System::where('phase', $job->phase)->orderBy('flag')->get()
                    ]);
                } else {
                    return view('job.show.index', [
                        'job' => $job,
                    ]);
                }
            } else {
                abort(401);
            }
        }
    }

    public function edit(Request $request, Job $job)
    {
        //echo '-' . $request->user()->team . ' : ' . $job;
        $canDelete = $this->deleteAuth($request, $job);
        $canReject = $this->rejectAuth($request, $job);

        if ($request->user()->team == 'OBS') { //ROOT
            return view('job.edit.index', [
                'job' => $job,
                'canDelete' => 1,
                'canReject' => 1,
                'departments' => Department::all(),
                'hardwareItems' => HardwareItem::all(),
                'call_categories' => CallCategory::orderBy('code')->get(),
                'systems_ph1' => System::where('phase', 1)->orderBy('flag')->get(),
                'systems_ph2' => System::where('phase', 2)->orderBy('flag')->get(),
                'systems_ph3' => System::where('phase', 3)->orderBy('flag')->get(),
                'systems_ph4' => System::where('phase', 4)->orderBy('flag')->get(),
                'systems' => System::where('phase', $job->phase)->orderBy('flag')->get(),
                'solve_descriptions' =>SolveDescription::where('phase', $job->phase)->get(),
            ]);
        } else  if ($this->editAuth($request, $job)) {
            if ($request->user()->team == 'CC' or $request->user()->team == 'DOL') {
                return view('job.edit.index', [
                    'job' => $job,
                    'canDelete' => $canDelete,
                    'canReject' => $canReject,
                    'departments' => Department::all(),
                    'hardwareItems' => HardwareItem::all(),
                    'call_categories' => CallCategory::orderBy('code')->get(),
                    'systems_ph1' => System::where('phase', 1)->orderBy('flag')->get(),
                    'systems_ph2' => System::where('phase', 2)->orderBy('flag')->get(),
                    'systems_ph3' => System::where('phase', 3)->orderBy('flag')->get(),
                    'systems_ph4' => System::where('phase', 4)->orderBy('flag')->get(),
                    'solve_descriptions' =>SolveDescription::where('phase', $job->phase)->get(),
                ]);
                //HardwareItem::where('phase', $request->phase)-> where('departments_id', $request->department)-> where('id', $request->get('id'))->first();

            } elseif ($request->user()->team == 'SA') {
                return view('job.edit.index', [
                    'job' => $job,
                    'canDelete' => $canDelete,
                    'canReject' => $canReject,
                    'call_categories' => CallCategory::orderBy('code')->get(),
                    'systems' => System::where('phase', $job->phase)->orderBy('flag')->get(),
                    'solve_descriptions' =>SolveDescription::where('phase', $job->phase)->get(),
                ]);
            } else {
                return view('job.edit.index', [
                    'call_categories' => CallCategory::orderBy('code')->get(),
                    'systems' => System::where('phase', $job->phase)->orderBy('flag')->get(),
                    'job' => $job,
                    'solve_descriptions' =>SolveDescription::where('phase', $job->phase)->get(),
                    'canDelete' => $canDelete,
                    'canReject' => $canReject,
                ]);
            }
        } else {
            return redirect('job/' . $job->id);
        }
    }

    public function queryJobDescription(Request $request)
    {
        $jobDescriptions = new Job;
        $jobDescriptions = Job::where('closed', '1');
        //$jobDescriptions = $jobDescriptions->where('tier2_solve_description', 'is not null');
        $jobDescriptions = $jobDescriptions->where('last_operator_team', 'SP');
        return $jobDescriptions;
    }

    public function update(JobRequest $request, Job $job)
    {
        if ($request->user()->team == 'OBS') {
            $job = $this->saveDataCC($request, $job);
            $job = $this->saveDataSP($request, $job);
            $job = $this->saveDataSA($request, $job);
            $job->save();

            return redirect('/job')->with('success', 'Job updated.');
        }

        if (!$this->editAuth($request, $job)) abort(401);

        if ($request->user()->team == 'CC' or $request->user()->team == 'DOL') {
            if ($job->tier2_forward == 'SCS' or $job->tier3_forward == 'SCS') {
                $validate = $this->validateCCSCS($request);

                if ($validate == 'pass') {
                    $job = $this->saveDataCCSCS($request, $job);
                } else {
                    return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
                }
            } else {
                $validate = $this->validateCC($request);

                if ($validate == 'pass') {
                    $job = $this->saveDataCC($request, $job);
                } else {
                    return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
                }

                if ($job->tier1_forward == 'SCS' or $job->call_category_id == '5') {
                    $validate = $this->validateCCSCS($request);

                    if ($validate == 'pass') {
                        $job = $this->saveDataCCSCS($request, $job);
                    } else {
                        return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
                    }
                }
            }
        } elseif ($request->user()->team == 'SP') {
            $validate = $this->validateSP($request);

            if ($validate == 'pass') {
                $job = $this->saveDataSP($request, $job);
            } else {
                return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
            }
        } elseif ($request->user()->team == 'SA') {
            $validate = $this->validateSANWST($request);

            if ($validate == 'pass') {
                $job = $this->saveDataSA($request, $job);
            } else {
                return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
            }
        } elseif ($request->user()->team == 'NW' or $request->user()->team == 'ST') {
            $validate = $this->validateSANWST($request);

            if ($validate == 'pass') {
                $job = $this->saveDataNWST($request, $job);
            } else {
                return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
            }
        } elseif ($request->user()->team == 'SCS') {
            $validate = $this->validateSCS($request);

            if ($validate == 'pass') {
                $job = $this->saveDataSCS($request, $job);
            } else {
                return redirect('/job/' . $job->id . '/edit')->withErrors([$validate]);
            }
        }

        $job->save();

        return redirect('/job')->with('success', 'Job updated.');
    }

    public function delete(Request $request, Job $job)
    {
        if (!$this->deleteAuth($request, $job)) abort(401);

        return view('job.delete', ['job' => $job]);
    }

    public function destroy(Request $request, Job $job)
    {
        if (!$this->deleteAuth($request, $job)) abort(401);

        $job->delete();

        return redirect('/job')->with('success', 'Job deleted.');
    }

    public function saReview(Request $request, Job $job)
    {
        if (($job->active_operator_team != 'SCS' and $job->last_operator_team != 'SCS')
            and ($job->active_operator_team != 'NW' and $job->last_operator_team != 'NW')
            and ($job->active_operator_team != 'ST' and $job->last_operator_team != 'ST')
            and $request->user()->team == 'SA'
        ) {
            $job = $this->saveDataSARW($request, $job);
            $job->save();
        } else {
            abort(401);
        }

        return redirect('/job/' . $job->id)->with('success', 'Job reviewed.');
    }

    public function accept(Request $request, Job $job)
    {
        if (!$this->acceptAuth($request, $job)) abort(401);

        if ($request->user()->team == 'SP') {
            $job->tier2_solve_user_id = $request->user()->id;
            $job->tier2_solve_user_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
        } elseif ($request->user()->team == 'SA' || $request->user()->team == 'NW' || $request->user()->team == 'ST') {
            $job->tier3_solve_user_id = $request->user()->id;
            $job->tier3_solve_user_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
        } elseif ($request->user()->team == 'SCS') {
            $job->scs_solve_user_id = $request->user()->id;
            $job->scs_solve_user_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
        }

        $job->active_operator_id = $request->user()->id;
        $job->save();

        $jobStack = new JobStack;
        $jobStack->job_id = $job->id;
        $jobStack->user_team = $request->user()->team;
        $jobStack->user_id = $request->user()->id;

        $topStack = JobStack::Top($job)->first();
        if ($topStack) $jobStack->stack_number = $topStack->stack_number + 1;
        else $jobStack->stack_number = 1;

        $jobStack->save();

        return redirect('/job/' . $job->id . '/edit')->with('success', 'Job accepted.');
    }

    public function rejectConfirm(Request $request, Job $job)
    {
        if (!$this->rejectAuth($request, $job)) abort(401);

        return view('job.reject', ['job' => $job]);
    }

    public function reject(Request $request, Job $job)
    {
        if (!$this->rejectAuth($request, $job)) abort(401);

        if ($request->user()->team == 'SP') {
            $job->tier2_solve_user_id = null;
            $job->tier2_solve_user_dtm = null;
            $job->tier2_solve_description = null;
            $job->tier2_solve_result = null;
            $job->tier2_solve_result_dtm = null;
            $job->tier2_forward = null;
        } elseif ($request->user()->team == 'SA' or $request->user()->team == 'NW' or $request->user()->team == 'ST') {
            $job->tier3_solve_user_id = null;
            $job->tier3_solve_user_dtm = null;
            $job->tier3_solve_description = null;
            $job->tier3_solve_result = null;
            $job->tier3_solve_result_dtm = null;
            $job->tier3_forward = null;
        } elseif ($request->user()->team == 'SCS') {
            $job->scs_solve_user_id = null;
            $job->scs_solve_user_dtm = null;
            $job->scs_solve_result_dtm = null;

            $scsjob = $job->scsjob;
            $scsjob->action = null;
            $scsjob->start_dtm = null;
            $scsjob->action_dtm = null;
            $scsjob->operator_name = null;
            $scsjob->cause = null;
            $scsjob->remark = null;
            $scsjob->save();
        }

        if ($job->closed == true) {
            $job->closed = null;
            $job->closed_at = null;
        }

        $job->active_operator_team = $request->user()->team;
        $job->active_operator_id = null;
        $job->save();

        $jobStack = JobStack::where('job_id', $job->id)
            ->orderBy('stack_number', 'desc')
            ->first();

        $jobStack->delete();

        return redirect('/job/' . $job->id)->with('success', 'Job rejected.');
    }

    public function confirmClose(Request $request, Job $job)
    {
        if (($request->user()->team == 'CC' or $request->user()->team == 'DOL') and $job->closed == true and $job->cc_confirm_closed == false) {
            $job->cc_confirm_closed_id = $request->user()->id;
            $job->cc_confirm_closed = true;
            $job->cc_confirm_closed_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
            $job->save();

            return redirect('/job')->with('success', 'Job confirm closed.');
        } else {
            abort(401);
        }
    }

    use dateDiffTrait;
    public function exportExcel(Request $request)
    {
        if ($request->user()->team == 'DOL') {
            return redirect()->back();
        }

        $first_day = null;
        $last_day = null;

        if (($request->get('job') == 'closed' or $request->get('job') == 'all')
            and (empty($request->get('from')) and empty($request->get('to')))
        ) {
            $first_day = date('Y-m-d', strtotime('first day of this month'));
            $last_day = date('Y-m-d', strtotime('last day of this month'));

            return redirect('/job?from=' . $first_day . '&to=' . $last_day . '&job=' . $request->get('job') . '&team=' . $request->get('team') . '&ticket=' . $request->get('ticket') . '&project=' . $request->get('project') . '&system=' . $request->get('system') . '&department=' . $request->get('department') . '&call_category=' . $request->get('call_category') . '&description=' . $request->get('description'));
        }

        $filename = 'DOL ' . date('Y-m-d');
        $col = $this->getExcelColumn();
        $row = 1;
        $jobs = $this->queryData($request)
            ->orderBy('created_at', 'asc')
            ->get();
        $ea = new \PHPExcel();

        $ea->getProperties()
            ->setCreator('CallLog')
            ->setTitle('CallLog')
            ->setLastModifiedBy('CallLog')
            ->setDescription('CallLog')
            ->setSubject('CallLog')
            ->setKeywords('CallLog')
            ->setCategory('CallLog');

        //sheet 1
        $ews = $ea->getSheet(0);
        $ews->setTitle('CallLog'); //sheet name

        //header
        $ews->mergeCells($col[0] . $row . ':' . $col[36] . $row); // month

        if ($first_day == null or $last_day == null) {
            $ews->setCellValue($col[0] . $row, date('Y-M'));
        } else {
            $ews->setCellValue($col[0] . $row, date('Y-M-d', $first_day) . ' ถึง ' . date('Y-M-d', $last_day));
        }

        $row++; //2
        $row++; //3

        $c = 0;
        $start_c = $c;
        $ews->setCellValue($col[$c++] . $row, 'วัน');
        $ews->setCellValue($col[$c++] . $row, 'เวลา');
        $ews->setCellValue($col[$c++] . $row, 'หน่วยงาน');
        $ews->setCellValue($col[$c++] . $row, 'โครงการ');
        $ews->setCellValue($col[$c++] . $row, 'ชื่อผู้แจ้ง');
        $ews->setCellValue($col[$c++] . $row, 'โทร');
        $ews->setCellValue($col[$c++] . $row, 'ประเภทผู้แจ้ง');
        $ews->setCellValue($col[$c++] . $row, 'Ticket No.');
        $ews->setCellValue($col[$c++] . $row, 'Counter');
        $ews->setCellValue($col[$c++] . $row, 'SW Version');
        $ews->setCellValue($col[$c++] . $row, 'รายละเอียดปัญหา');
        $ews->setCellValue($col[$c++] . $row, 'บันทึกการแก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'ผลการแก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'ส่งต่อ');
        $end_c = $c - 1;

        $ews->mergeCells($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . ($row - 1)); //TIER1 Helpdesk
        $ews->setCellValue($col[$start_c] . ($row - 1), 'TIER1 Helpdesk');
        $ews->getStyle($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . $row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ADD8E6');

        $start_c = $c;
        $ews->setCellValue($col[$c++] . $row, 'ผู้แก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'เวลา');
        $ews->setCellValue($col[$c++] . $row, 'บันทึกการแก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'ผลการแก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'เวลา');
        $ews->setCellValue($col[$c++] . $row, 'ส่งต่อ');
        $end_c = $c - 1;

        $ews->mergeCells($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . ($row - 1)); //TIER2 Support
        $ews->setCellValue($col[$start_c] . ($row - 1), 'TIER2 Support');
        $ews->getStyle($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . $row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB6C1');

        $start_c = $c;
        $ews->setCellValue($col[$c++] . $row, 'ผู้แก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'เวลา');
        $ews->setCellValue($col[$c++] . $row, 'บันทึกการแก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'ผลการแก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'เวลา');
        $ews->setCellValue($col[$c++] . $row, 'ส่งต่อ');
        $end_c = $c - 1;

        $ews->mergeCells($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . ($row - 1)); //TIER3
        $ews->setCellValue($col[$start_c] . ($row - 1), 'TIER3');
        $ews->getStyle($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . $row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA07A');

        $start_c = $c;
        $ews->setCellValue($col[$c++] . $row, 'วัน - เวลา แก้ไขเสร็จ');
        $ews->setCellValue($col[$c++] . $row, 'เวลาที่ใช้แก้ไข');
        $ews->setCellValue($col[$c++] . $row, 'กลุ่มปัญหา');
        $ews->setCellValue($col[$c++] . $row, 'ระบบงานหลัก');
        $ews->setCellValue($col[$c++] . $row, 'ระบบงานรอง');
        $ews->setCellValue($col[$c++] . $row, 'หมายเหตุ');
        $end_c = $c - 1;

        $ews->mergeCells($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . ($row - 1)); //RESULT
        $ews->setCellValue($col[$start_c] . ($row - 1), 'RESULT');
        $ews->getStyle($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . $row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('98FB98');

        $start_c = $c;
        $ews->setCellValue($col[$c++] . $row, 'กลุ่มปัญหา');
        $ews->setCellValue($col[$c++] . $row, 'ระบบงานหลัก');
        $ews->setCellValue($col[$c++] . $row, 'ระบบงานรอง');
        $ews->setCellValue($col[$c++] . $row, 'Return Job');
        $ews->setCellValue($col[$c++] . $row, 'หมายเหตุ');
        $end_c = $c - 1;

        $ews->mergeCells($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . ($row - 1)); //SA Review
        $ews->setCellValue($col[$start_c] . ($row - 1), 'SA Review');
        $ews->getStyle($col[$start_c] . ($row - 1) . ':' . $col[$end_c] . $row)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9999ff');

        $close_count = 0;
        $active_count = 0;
        $call_count = [
            '101' => 0, '102' => 0, '103' => 0, '104' => 0, '105' => 0, '106' => 0, '107' => 0,
            '201' => 0, '202' => 0, '203' => 0, '204' => 0, '205' => 0, '301' => 0, '302' => 0
        ];
        $system_count = [
            'REG' => 0, 'MNG' => 0, 'CTN' => 0, 'BPM' => 0, 'HRM' => 0, 'EXP' => 0, 'INA' => 0, 'INV' => 0,
            'FIN' => 0, 'MSS' => 0, 'USP' => 0, 'PRC' => 0, 'WAH' => 0, 'VEH' => 0, 'MTN' => 0, 'BLD' => 0, 'ONL' => 0,
            'EPA' => 0, 'SVA' => 0, 'SVC' => 0, 'LIS' => 0, 'GSS' => 0, 'MTD' => 0, 'IES' => 0, 'ADM' => 0, 'MAS' => 0,
            'BCK' => 0, 'SPC' => 0, 'ECH' => 0, 'PLS' => 0, 'EVD' => 0, 'APS' => 0, 'ESP' => 0, 'MIS' => 0, 'SDM' => 0,
            'MRI' => 0, 'EDM' => 0, 'SDX' => 0, 'LMS' => 0, 'LUS' => 0, 'OMW' => 0, 'DMS' => 0, 'BCK' => 0, 'SVO' => 0, 'SVM' => 0, 'UDM' => 0, 'GIS' => 0, 'SSI' => 0, 'ELM' => 0, 'M84' => 0, 'LSS' => 0, 'EBD' => 0, 'OFL' => 0, 'OFL' => 0
        ];
        $sp_count = array();
        $cc_count = 0;
        $sa_count = 0;
        $st_count = 0;
        $nw_count = 0;
        $scs_count = 0;

        //data
        foreach ($jobs as $job) {

            $row++; //4
            $c = 0;

            //TIER1
            $ews->setCellValue($col[$c++] . $row, explode(' ', $job->created_at)[0]);
            $ews->setCellValue($col[$c++] . $row, explode(' ', $job->created_at)[1]);
            $ews->setCellValue($col[$c++] . $row, $job->department->name);
            $ews->setCellValue($col[$c++] . $row, 'DOL' . $job->department->phase);
            $ews->setCellValue($col[$c++] . $row, $job->informer_name);
            $ews->setCellValue($col[$c++] . $row, $job->informer_phone_number);
            $ews->setCellValue($col[$c++] . $row, $job->informer_type == 'C' ? 'ลูกค้า' : 'ภายใน (บริษัท)');
            $ews->setCellValue($col[$c++] . $row, $job->ticket_no);
            $ews->setCellValue($col[$c++] . $row, $job->counter);
            $ews->setCellValue($col[$c++] . $row, $job->sw_version);
            $ews->setCellValue($col[$c++] . $row, $job->description);
            $ews->setCellValue($col[$c++] . $row, $job->tier1_solve_description);

            if ($job->tier1_solve_result == '0' or $job->tier1_solve_result == 0) {
                $ews->setCellValue($col[$c++] . $row, 'ไม่ได้');
            } elseif ($job->tier1_solve_result == '1' or $job->tier1_solve_result == 1) {
                $ews->setCellValue($col[$c++] . $row, 'ได้');
            }

            $ews->setCellValue($col[$c++] . $row, $job->tier1_forward);

            //TIER2
            $ews->setCellValue($col[$c++] . $row, $job->tier2_solve_user ? $job->tier2_solve_user->name : '');
            $ews->setCellValue($col[$c++] . $row, $job->tier2_solve_user_dtm);
            $ews->setCellValue($col[$c++] . $row, $job->tier2_solve_description);

            if ($job->tier2_solve_result_dtm != null) {
                if ($job->tier2_solve_result == '0' or $job->tier2_solve_result == 0) {
                    $ews->setCellValue($col[$c++] . $row, 'ไม่ได้');
                } elseif ($job->tier2_solve_result == '1' or $job->tier2_solve_result == 1) {
                    $ews->setCellValue($col[$c++] . $row, 'ได้');
                }
            } else {
                $ews->setCellValue($col[$c++] . $row, '');
            }

            $ews->setCellValue($col[$c++] . $row, $job->tier2_solve_result_dtm);
            $ews->setCellValue($col[$c++] . $row, $job->tier2_forward);


            //TIER3
            $ews->setCellValue($col[$c++] . $row, $job->tier3_solve_user ? $job->tier3_solve_user->name : '');
            $ews->setCellValue($col[$c++] . $row, $job->tier3_solve_user_dtm);
            $ews->setCellValue($col[$c++] . $row, $job->tier3_solve_description);

            if ($job->tier3_solve_result_dtm != null) {
                if ($job->tier3_solve_result == '0' or $job->tier3_solve_result == false) {
                    $ews->setCellValue($col[$c++] . $row, 'ไม่ได้');
                } elseif ($job->tier3_solve_result == '1' or $job->tier3_solve_result == true) {
                    $ews->setCellValue($col[$c++] . $row, 'ได้');
                }
            } else {
                $ews->setCellValue($col[$c++] . $row, '');
            }

            $ews->setCellValue($col[$c++] . $row, $job->tier3_solve_result_dtm);
            $ews->setCellValue($col[$c++] . $row, $job->tier3_forward);


            //RESULT
            if($job->call_category_id == 5){
                //On site service job
                if ($job->scsjob){
                    $ews->setCellValue($col[$c++] . $row, $job->scsjob->action_dtm);
                    if ($job->scsjob->action_dtm != null) {
                        if ($job->created_at != $job->scsjob->action_dtm) {
                            $diff = $this->datediff($job->scsjob->action_dtm, $job->created_at);
                            $ews->setCellValue($col[$c++] . $row, $diff);
                        } else {
                            $ews->setCellValue($col[$c++] . $row, "0 Days, 00:00:00");
                        }
        
                        $close_count++;
                    } else {
                        $ews->setCellValue($col[$c++] . $row, '');
                    }
                }else{
                    $ews->setCellValue($col[$c++] . $row, $job->closed_at);
                    if ($job->closed_at != null) {
                        if ($job->created_at != $job->closed_at) {
                            $diff = $this->datediff($job->closed_at, $job->created_at);
                            $ews->setCellValue($col[$c++] . $row, $diff);
                        } else {
                            $ews->setCellValue($col[$c++] . $row, "0 Days, 00:00:00");
                        }
        
                        $close_count++;
                    } else {
                        $ews->setCellValue($col[$c++] . $row, '');
                    }
                }
                
            }else{
                $ews->setCellValue($col[$c++] . $row, $job->closed_at);
                if ($job->closed_at != null) {
                    if ($job->created_at != $job->closed_at) {
                        $diff = $this->datediff($job->closed_at, $job->created_at);
                        $ews->setCellValue($col[$c++] . $row, $diff);
                    } else {
                        $ews->setCellValue($col[$c++] . $row, "0 Days, 00:00:00");
                    }
    
                    $close_count++;
                } else {
                    $ews->setCellValue($col[$c++] . $row, '');
                }
            }
            

            $ews->setCellValue($col[$c++] . $row, $job->call_category ? $job->call_category->problem_group : '');
            $ews->setCellValue($col[$c++] . $row, $job->primary_system ? $job->primary_system->flag : '');
            $ews->setCellValue($col[$c++] . $row, $job->secondary_system ? $job->secondary_system->flag : '');
            if($job->call_category_id == 5){
                if ($job->scsjob){
                    $ews->setCellValue($col[$c++] . $row, $job->scsjob->cause . " \n " . $job->scsjob->action);
                }else{
                    $ews->setCellValue($col[$c++] . $row, $job->remark);
                }
            }else{
                $ews->setCellValue($col[$c++] . $row, $job->remark);
            }

            //SA Review
            $ews->setCellValue($col[$c++] . $row, $job->sa_rw_call_category ? $job->sa_rw_call_category->problem_group : '');
            $ews->setCellValue($col[$c++] . $row, $job->sa_rw_primary_system ? $job->sa_rw_primary_system->flag : '');
            $ews->setCellValue($col[$c++] . $row, $job->sa_rw_secondary_system ? $job->sa_rw_secondary_system->flag : '');
            $ews->setCellValue($col[$c++] . $row, $job->sa_rw_return_job ? '1' : '');
            $ews->setCellValue($col[$c++] . $row, $job->sa_rw_remark);

            //style
            if ($job->closed_at == null) {
                $ews->getStyle($col[0] . $row . ':' . $col[$c - 1] . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                        ),
                    )
                );

                $active_count++;
            }

            $effect_row = $col[0] . $row . ':' . $col[$c - 1] . $row;

            $ews->getStyle($effect_row)->getAlignment()->setWrapText(true);
            $ews->getStyle($effect_row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $ews->getStyle($effect_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

            //count
            if ($job->sa_rw_call_category) {
                $call_count[$job->sa_rw_call_category->code]++;
            } elseif ($job->call_category) {
                $call_count[$job->call_category->code]++;
            }

            if ($job->sa_rw_primary_system) {
                $system_count[$job->sa_rw_primary_system->flag]++;
            } elseif ($job->primary_system) {
                $system_count[$job->primary_system->flag]++;
            }

            if ($job->tier1_solve_result) {
                $cc_count++;
            }

            if ($job->tier2_solve_result) {
                if ($job->tier2_solve_user) {
                    if (array_key_exists($job->tier2_solve_user->name, $sp_count)) {
                        $sp_count[$job->tier2_solve_user->name]++;
                    } else {
                        $sp_count[$job->tier2_solve_user->name] = 1;
                    }
                }
            }

            if ($job->tier3_solve_result) {
                if ($job->last_operator_team == 'SA') {
                    $sa_count++;
                } elseif ($job->last_operator_team == 'NW') {
                    $nw_count++;
                } elseif ($job->last_operator_team == 'ST') {
                    $st_count++;
                }
            }
        }

        //style
        $header = 'a1:ak3';
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $ews->getStyle($header)->applyFromArray($style);

        $c = 0;
        $ews->getColumnDimension($col[$c++])->setWidth(11);
        $ews->getColumnDimension($col[$c++])->setWidth(9);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setWidth(10);
        $ews->getColumnDimension($col[$c++])->setWidth(14);
        $ews->getColumnDimension($col[$c++])->setWidth(60);
        $ews->getColumnDimension($col[$c++])->setWidth(60);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setWidth(60);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setWidth(60);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setAutoSize(true);
        $ews->getColumnDimension($col[$c++])->setWidth(60);

        //writer
        $writer = \PHPExcel_IOFactory::createWriter($ea, 'Excel2007');
        $writer->setIncludeCharts(true);

        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        // \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
        // /home/admin/web/ubuntu-s-1vcpu-2gb-sgp1-01.example.com/public_html/storage/tmp
        // $writer->save('/home/admin/tmp');
        // $writer->save('/home/admin/web/ubuntu-s-1vcpu-2gb-sgp1-01.example.com/public_html/storage/tmp/' . $filename . '.xlsx');
        // unlink('/home/admin/tmp');
        $writer->save('php://output');
    }

    public function exportExcelSCS(Request $request)
    {
        // TODO : Create scs excel
    }

    public function export(Request $request)
    {
        $first_day = null;
        $last_day = null;

        if (($request->get('job') == 'closed' or $request->get('job') == 'all')
            and (empty($request->get('from')) and empty($request->get('to')))
        ) {
            $first_day = date('Y-m-d', strtotime('first day of this month'));
            $last_day = date('Y-m-d', strtotime('last day of this month'));

            return redirect('/job?from=' . $first_day . '&to=' . $last_day . '&job=' . $request->get('job') . '&team=' . $request->get('team') . '&ticket=' . $request->get('ticket') . '&project=' . $request->get('project') . '&system=' . $request->get('system') . '&department=' . $request->get('department') . '&call_category=' . $request->get('call_category') . '&description=' . $request->get('description'));
        }

        $filename = 'DOL ' . date('Y-m-d');

        $jobs = null;

        if ($request->get('job') == 'closed') {
            $jobs = Job::where('closed', true);
        } elseif ($request->get('job') == 'all') {
            $jobs = Job::where('id', '>', 0);
        } else {
            $jobs = Job::where('cc_confirm_closed', false);
        }

        if ($request->user()->team != 'CC' and $request->user()->team != 'SP' and $request->user()->team != 'OBS') {
            if ($request->get('job') != 'all' and $request->get('job') != 'closed') {
                $jobs = $jobs->where('active_operator_team', $request->user()->team);
            }
        }

        if ($request->get('from') and $request->get('to')) {
            if ($request->get('from') == $request->get('to')) {
                $jobs = $jobs->whereBetween('created_at', [
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('from') . ' 00.00.00'),
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('from') . ' 23.59.59')
                ]);
            } else {
                $jobs = $jobs->whereBetween('created_at', [
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('from') . ' 00.00.00'),
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('to') . ' 23.59.59')
                ]);
            }
        }

        if ($request->get('team')) {
            $jobs = $jobs->where(function ($query) use ($request) {

                $query->where(function ($query) use ($request) {
                    if (strpos($request->get('team'), '-')) {
                        $query->where('closed', true)
                            ->whereIn('last_operator_team', explode('-', $request->get('team')));
                    } else {
                        $query->where('closed', true)
                            ->where('last_operator_team', $request->get('team'));
                    }
                })->orWhere(function ($query) use ($request) {
                    if (strpos($request->get('team'), '-')) {
                        $query->where('closed', false)
                            ->whereIn('active_operator_team', explode('-', $request->get('team')));
                    } else {
                        $query->where('closed', false)
                            ->where('active_operator_team', $request->get('team'));
                    }
                });
            });
        }

        if ($request->get('ticket')) {
            $jobs = $jobs->where('ticket_no', 'like', '%' . $request->get('ticket') . '%');
        }

        if ($request->get('department')) {
            $jobs = $jobs->where('department_id', $request->get('department'));
        }

        if ($request->get('description')) {
            $jobs = $jobs->where('description', 'like', '%' . $request->get('description') . '%');
        }

        if ($request->get('project')) {
            $jobs = $jobs->where('phase', $request->get('project'));
        }

        if ($request->get('system')) {
            $jobs = $jobs->where('primary_system_id', $request->get('system'));
        }

        if ($request->get('call_category')) {
            $jobs = $jobs->where('call_category_id', $request->get('call_category'));
        }

        $jobs = $jobs->orderBy('created_at', 'asc');

        $ea = new \PHPExcel();

        $ea->getProperties()
            ->setCreator('CallLog')
            ->setTitle('CallLog')
            ->setLastModifiedBy('CallLog')
            ->setDescription('CallLog')
            ->setSubject('CallLog')
            ->setKeywords('CallLog')
            ->setCategory('CallLog');

        //sheet 1
        $ews = $ea->getSheet(0);
        $ews->setTitle('CallLog'); //sheet name

        //header
        $ews->mergeCells('a1:y1'); // month

        if ($first_day == null or $last_day == null) {
            $ews->setCellValue('a1', date('Y-M'));
        } else {
            $ews->setCellValue('a1', date('Y-M-d', $first_day) . ' ถึง ' . date('Y-M-d', $last_day));
        }

        $ews->mergeCells('a2:l2'); //TIER1 Helpdesk
        $ews->setCellValue('a2', 'TIER1 Helpdesk');
        $ews->getStyle('a2:l3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('ADD8E6');

        $ews->setCellValue('a3', 'วัน - เวลา');
        $ews->setCellValue('b3', 'หน่วยงาน');
        $ews->setCellValue('c3', 'โครงการ');
        $ews->setCellValue('d3', 'ชื่อผู้แจ้ง');
        $ews->setCellValue('e3', 'โทร');
        $ews->setCellValue('f3', 'ประเภทผู้แจ้ง');
        $ews->setCellValue('g3', 'Ticket No.');
        $ews->setCellValue('h3', 'SW Version');
        $ews->setCellValue('i3', 'รายละเอียดปัญหา');
        $ews->setCellValue('j3', 'บันทึกการแก้ไข');
        $ews->setCellValue('k3', 'ผลการแก้ไข');
        $ews->setCellValue('l3', 'ส่งต่อ');

        $ews->mergeCells('m2:r2'); //TIER2 Support
        $ews->setCellValue('m2', 'TIER2 Support');
        $ews->getStyle('m2:r3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFB6C1');

        $ews->setCellValue('m3', 'ผู้แก้ไข');
        $ews->setCellValue('n3', 'เวลา');
        $ews->setCellValue('o3', 'บันทึกการแก้ไข');
        $ews->setCellValue('p3', 'ผลการแก้ไข');
        $ews->setCellValue('q3', 'เวลา');
        $ews->setCellValue('r3', 'ส่งต่อ');


        $ews->mergeCells('s2:x2'); //TIER3
        $ews->setCellValue('s2', 'TIER3');
        $ews->getStyle('s2:x3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFA07A');

        $ews->setCellValue('s3', 'ผู้แก้ไข');
        $ews->setCellValue('t3', 'เวลา');
        $ews->setCellValue('u3', 'บันทึกการแก้ไข');
        $ews->setCellValue('v3', 'ผลการแก้ไข');
        $ews->setCellValue('w3', 'เวลา');
        $ews->setCellValue('x3', 'ส่งต่อ');


        $ews->mergeCells('y2:ad2'); //RESULT
        $ews->setCellValue('y2', 'RESULT');
        $ews->getStyle('y2:ad3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('98FB98');

        $ews->setCellValue('y3', 'วัน - เวลา แก้ไขเสร็จ');
        $ews->setCellValue('z3', 'เวลาที่ใช้แก้ไข');
        $ews->setCellValue('aa3', 'กลุ่มปัญหา');
        $ews->setCellValue('ab3', 'ระบบงานหลัก');
        $ews->setCellValue('ac3', 'ระบบงานรอง');
        $ews->setCellValue('ad3', 'หมายเหตุ');

        $ews->mergeCells('ae2:ai2'); //SA Review
        $ews->setCellValue('ae2', 'SA Review');
        $ews->setCellValue('ae3', 'กลุ่มปัญหา');
        $ews->setCellValue('af3', 'ระบบงานหลัก');
        $ews->setCellValue('ag3', 'ระบบงานรอง');
        $ews->setCellValue('ah3', 'Return Job');
        $ews->setCellValue('ai3', 'หมายเหตุ');
        $ews->getStyle('ae2:ai3')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('9999ff');

        $close_count = 0;
        $active_count = 0;
        $call_count = array(
            '101' => 0, '102' => 0, '103' => 0, '104' => 0, '105' => 0, '106' => 0, '107' => 0,
            '201' => 0, '202' => 0, '203' => 0, '204' => 0, '205' => 0, '301' => 0, '302' => 0
        );
        $system_count = array(
            'REG' => 0, 'MNG' => 0, 'CTN' => 0, 'BPM' => 0, 'HRM' => 0, 'EXP' => 0, 'INA' => 0, 'INV' => 0,
            'FIN' => 0, 'MSS' => 0, 'USP' => 0, 'PRC' => 0, 'WAH' => 0, 'VEH' => 0, 'MTN' => 0, 'BLD' => 0, 'ONL' => 0,
            'EPA' => 0, 'SVA' => 0, 'SVC' => 0, 'LIS' => 0, 'GSS' => 0, 'MTD' => 0, 'IES' => 0, 'ADM' => 0, 'MAS' => 0,
            'BCK' => 0, 'SPC' => 0, 'ECH' => 0, 'PLS' => 0, 'EVD' => 0, 'APS' => 0, 'ESP' => 0, 'MIS' => 0, 'SDM' => 0,
            'MRI' => 0, 'EDM' => 0, 'SDX' => 0, 'LMS' => 0, 'LUS' => 0, 'OMW' => 0, 'DMS' => 0, 'BCK' => 0
        );
        $sp_count = array();
        $cc_count = 0;
        $sa_count = 0;
        $st_count = 0;
        $nw_count = 0;
        $scs_count = 0;

        //data
        $start_row = 4;
        foreach ($jobs->get() as $job) {


            //TIER1
            $ews->setCellValue('a' . $start_row, $job->created_at);
            $ews->setCellValue('b' . $start_row, $job->department->name);
            $ews->setCellValue('c' . $start_row, 'DOL' . $job->department->phase);
            $ews->setCellValue('d' . $start_row, $job->informer_name);
            $ews->setCellValue('e' . $start_row, $job->informer_phone_number);
            $ews->setCellValue('f' . $start_row, $job->informer_type == 'C' ? 'ลูกค้า' : 'ภายใน (บริษัท)');
            $ews->setCellValue('g' . $start_row, $job->ticket_no);

            $ews->setCellValue('h' . $start_row, $job->sw_version);
            $ews->setCellValue('i' . $start_row, $job->description);
            $ews->setCellValue('j' . $start_row, $job->tier1_solve_description);

            if ($job->tier1_solve_result == '0' or $job->tier1_solve_result == 0) {
                $ews->setCellValue('k' . $start_row, 'ไม่ได้');
            } elseif ($job->tier1_solve_result == '1' or $job->tier1_solve_result == 1) {
                $ews->setCellValue('k' . $start_row, 'ได้');
            }

            $ews->setCellValue('l' . $start_row, $job->tier1_forward);

            //TIER2
            $ews->setCellValue('m' . $start_row, $job->tier2_solve_user ? $job->tier2_solve_user->name : '');
            $ews->setCellValue('n' . $start_row, $job->tier2_solve_user_dtm);
            $ews->setCellValue('o' . $start_row, $job->tier2_solve_description);

            if ($job->tier2_solve_result_dtm != null) {
                if ($job->tier2_solve_result == '0' or $job->tier2_solve_result == 0) {
                    $ews->setCellValue('p' . $start_row, 'ไม่ได้');
                } elseif ($job->tier2_solve_result == '1' or $job->tier2_solve_result == 1) {
                    $ews->setCellValue('p' . $start_row, 'ได้');
                }
            }

            $ews->setCellValue('q' . $start_row, $job->tier2_solve_result_dtm);
            $ews->setCellValue('r' . $start_row, $job->tier2_forward);


            //TIER3
            $ews->setCellValue('s' . $start_row, $job->tier3_solve_user ? $job->tier3_solve_user->name : '');
            $ews->setCellValue('t' . $start_row, $job->tier3_solve_user_dtm);
            $ews->setCellValue('u' . $start_row, $job->tier3_solve_description);

            if ($job->tier3_solve_result_dtm != null) {
                if ($job->tier3_solve_result == '0' or $job->tier3_solve_result == false) {
                    $ews->setCellValue('v' . $start_row, 'ไม่ได้');
                } elseif ($job->tier3_solve_result == '1' or $job->tier3_solve_result == true) {
                    $ews->setCellValue('v' . $start_row, 'ได้');
                }
            }

            $ews->setCellValue('w' . $start_row, $job->tier3_solve_result_dtm);
            $ews->setCellValue('x' . $start_row, $job->tier3_forward);


            //RESULT
            $ews->setCellValue('y' . $start_row, $job->closed_at);

            if ($job->closed_at != null) {

                if ($job->created_at != $job->closed_at) {

                    $diff = $this->datediff($job->closed_at, $job->created_at);

                    $ews->setCellValue('z' . $start_row, $diff);
                } else {
                    $ews->setCellValue('z' . $start_row, "0 Days, 00:00:00");
                }

                $close_count++;
            } else {
                $ews->getStyle('a' . $start_row . ':ai' . $start_row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                        ),
                    )
                );

                $active_count++;
            }

            $ews->setCellValue('aa' . $start_row, $job->call_category ? $job->call_category->problem_group : '');
            $ews->setCellValue('ab' . $start_row, $job->primary_system ? $job->primary_system->flag : '');
            $ews->setCellValue('ac' . $start_row, $job->secondary_system ? $job->secondary_system->flag : '');
            $ews->setCellValue('ad' . $start_row, $job->remark);

            //SA Review
            $ews->setCellValue('ae' . $start_row, $job->sa_rw_call_category ? $job->sa_rw_call_category->problem_group : '');
            $ews->setCellValue('af' . $start_row, $job->sa_rw_primary_system ? $job->sa_rw_primary_system->flag : '');
            $ews->setCellValue('ag' . $start_row, $job->sa_rw_secondary_system ? $job->sa_rw_secondary_system->flag : '');
            $ews->setCellValue('ah' . $start_row, $job->sa_rw_return_job ? '1' : '');
            $ews->setCellValue('ai' . $start_row, $job->sa_rw_remark);


            //style
            $effect_row = 'a' . $start_row . ':ai' . $start_row;

            $ews->getStyle($effect_row)->getAlignment()->setWrapText(true);
            $ews->getStyle($effect_row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $ews->getStyle($effect_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);

            if ($job->sa_rw_call_category) {
                $call_count[$job->sa_rw_call_category->code]++;
            } elseif ($job->call_category) {
                $call_count[$job->call_category->code]++;
            }

            if ($job->sa_rw_primary_system) {
                $system_count[$job->sa_rw_primary_system->flag]++;
            } elseif ($job->primary_system) {
                $system_count[$job->primary_system->flag]++;
            }

            if ($job->tier1_solve_result) {
                $cc_count++;
            }

            if ($job->tier2_solve_result) {
                if ($job->tier2_solve_user) {
                    if (array_key_exists($job->tier2_solve_user->name, $sp_count)) {
                        $sp_count[$job->tier2_solve_user->name]++;
                    } else {
                        $sp_count[$job->tier2_solve_user->name] = 1;
                    }
                }
            }

            if ($job->tier3_solve_result) {
                if ($job->last_operator_team == 'SA') {
                    $sa_count++;
                } elseif ($job->last_operator_team == 'NW') {
                    $nw_count++;
                } elseif ($job->last_operator_team == 'ST') {
                    $st_count++;
                }
            }

            $start_row++;
        }

        //style
        $header = 'a1:ai3';
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $ews->getStyle($header)->applyFromArray($style);

        $ews->getColumnDimension('a')->setWidth(18);
        $ews->getColumnDimension('b')->setAutoSize(true);
        $ews->getColumnDimension('c')->setAutoSize(true);
        $ews->getColumnDimension('d')->setAutoSize(true);
        $ews->getColumnDimension('e')->setAutoSize(true);
        $ews->getColumnDimension('f')->setAutoSize(true);
        $ews->getColumnDimension('g')->setWidth(14);
        $ews->getColumnDimension('h')->setAutoSize(true);
        $ews->getColumnDimension('i')->setWidth(60);
        $ews->getColumnDimension('j')->setWidth(60);
        $ews->getColumnDimension('k')->setAutoSize(true);
        $ews->getColumnDimension('l')->setAutoSize(true);
        $ews->getColumnDimension('m')->setAutoSize(true);
        $ews->getColumnDimension('n')->setAutoSize(true);
        $ews->getColumnDimension('o')->setWidth(60);
        $ews->getColumnDimension('p')->setAutoSize(true);
        $ews->getColumnDimension('q')->setAutoSize(true);
        $ews->getColumnDimension('r')->setAutoSize(true);
        $ews->getColumnDimension('s')->setAutoSize(true);
        $ews->getColumnDimension('t')->setAutoSize(true);
        $ews->getColumnDimension('u')->setWidth(60);
        $ews->getColumnDimension('v')->setAutoSize(true);
        $ews->getColumnDimension('w')->setAutoSize(true);
        $ews->getColumnDimension('x')->setAutoSize(true);
        $ews->getColumnDimension('y')->setAutoSize(true);
        $ews->getColumnDimension('z')->setAutoSize(true);
        $ews->getColumnDimension('aa')->setAutoSize(true);
        $ews->getColumnDimension('ab')->setAutoSize(true);
        $ews->getColumnDimension('ac')->setAutoSize(true);
        $ews->getColumnDimension('ad')->setAutoSize(true);
        $ews->getColumnDimension('ae')->setAutoSize(true);
        $ews->getColumnDimension('af')->setAutoSize(true);
        $ews->getColumnDimension('ag')->setAutoSize(true);
        $ews->getColumnDimension('ah')->setAutoSize(true);
        $ews->getColumnDimension('ai')->setWidth(60);


        //sheet2
        $ews2 = new \PHPExcel_Worksheet($ea, 'Report');
        $ea->addSheet($ews2);
        $ews2->setTitle('Report');

        $ews2->mergeCells('a1:l1');

        if ($first_day == null or $last_day == null) {
            $ews2->setCellValue('a1', 'รายงานแสดงจำนวน Job ที่มีการบันทึก  ' . date('Y-M'));
        } else {
            $ews2->setCellValue('a1', 'รายงานแสดงจำนวน Job ที่มีการบันทึก  ' . date('Y-M-d', $first_day) . ' ถึง ' . date('Y-M-d', $last_day));
        }

        $header = 'a1:ad3';
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
        );
        $ews2->getStyle('a1')->applyFromArray($style);

        $header_style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $border_style = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $summary_style = array(
            'font' => array('bold' => true,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $report_start = 3;

        $jobs_group_call = $jobs->select('call_category_id', DB::raw('count(*) as total'))
            ->groupBy('call_category_id')
            ->get();

        $ews2->setCellValue('a' . $report_start, 'ลักษณะกลุ่มปัญหา');
        $ews2->setCellValue('b' . $report_start, 'จำนวน Job');
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($header_style);
        $report_start++;

        $call_total = 0;
        $call_categories = CallCategory::orderBy('code')->get();

        foreach ($call_categories as $call_category) {
            $ews2->setCellValue('a' . $report_start, $call_category->problem_group);
            $ews2->setCellValue('b' . $report_start, 0);
            $ews2->setCellValue('b' . $report_start, $call_count[$call_category->code]);
            $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
            $call_total += $call_count[$call_category->code];
            $report_start++;
        }

        $ews2->setCellValue('a' . $report_start, 'รวม');
        $ews2->setCellValue('b' . $report_start, $call_total);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($summary_style);
        $report_start++;

        $report_start = 28;

        $ews2->setCellValue('a' . $report_start, 'ลักษณะงาน');
        $ews2->setCellValue('b' . $report_start, 'จำนวน');
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($header_style);
        $report_start++;

        $ews2->setCellValue('a' . $report_start, 'Job ที่ปิดงานได้');
        $ews2->setCellValue('b' . $report_start, $close_count);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
        $report_start++;

        $ews2->setCellValue('a' . $report_start, 'Job ที่ไม่สามารถปิดงานได้');
        $ews2->setCellValue('b' . $report_start, $active_count);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
        $report_start++;

        $report_start = 41;

        $ews2->setCellValue('a' . $report_start, 'ระบบงาน');
        $ews2->setCellValue('b' . $report_start, 'จำนวน');
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($header_style);
        $report_start++;

        arsort($system_count);

        foreach ($system_count as $system => $val) {
            $ews2->setCellValue('a' . $report_start, $system);
            $ews2->setCellValue('b' . $report_start, $system_count[$system]);
            $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
            $report_start++;
        }

        $ews2->setCellValue('a' . $report_start, 'รวม');
        $ews2->setCellValue('b' . $report_start, array_sum($system_count));
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($summary_style);
        $report_start++;

        $report_start = $report_start_fix = 87;

        $ews2->setCellValue('a' . $report_start, 'การทำงานของทีม Support & Helpdesk');
        $ews2->setCellValue('b' . $report_start, 'จำนวน');
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($header_style);
        $report_start++;

        arsort($sp_count);

        foreach ($sp_count as $name => $val) {
            $ews2->setCellValue('a' . $report_start, $name);
            $ews2->setCellValue('b' . $report_start, $val);
            $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
            $report_start++;
        }

        $ews2->setCellValue('a' . $report_start, 'Call Center');
        $ews2->setCellValue('b' . $report_start, $cc_count);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
        $report_start++;

        $ews2->setCellValue('a' . $report_start, 'System Analysis');
        $ews2->setCellValue('b' . $report_start, $sa_count);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
        $report_start++;

        $ews2->setCellValue('a' . $report_start, 'Network');
        $ews2->setCellValue('b' . $report_start, $nw_count);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
        $report_start++;

        $ews2->setCellValue('a' . $report_start, 'System');
        $ews2->setCellValue('b' . $report_start, $st_count);
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($border_style);
        $report_start++;

        $ews2->setCellValue('a' . $report_start, 'รวม');
        $ews2->setCellValue('b' . $report_start, array_sum($sp_count) + $cc_count + $sa_count + $nw_count + $st_count);

        $ews2->addChart($this->add_user_chart($report_start_fix, $report_start));
        $ews2->getStyle('a' . $report_start . ':b' . $report_start)->applyFromArray($summary_style);
        $report_start++;

        $ews2->addChart($this->add_call_category_chart());
        $ews2->addChart($this->add_closed_active_chart());
        $ews2->addChart($this->add_system_chart());

        $ews2->getColumnDimension('a')->setAutoSize(true);
        $ews2->getColumnDimension('b')->setAutoSize(true);

        //writer
        $writer = \PHPExcel_IOFactory::createWriter($ea, 'Excel2007');
        $writer->setIncludeCharts(true);

        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        $writer->save('/home/admin/web/ubuntu-s-1vcpu-2gb-sgp1-01.example.com/public_html/storage/tmp/' . $filename . '.xlsx');
        // unlink('/home/admin/tmp');
        // $writer->save('php://output');
    }

    private function add_user_chart($report_start_fix, $report_start)
    {
        $dsl = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$b$' . $report_start_fix, NULL, 1),
        );

        $xal = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$' . ($report_start_fix + 1) . ':$A$' . ($report_start - 1), NULL, $report_start - $report_start_fix),
        );
        $dsv = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Report!$B$' . ($report_start_fix + 1) . ':$B$' . ($report_start - 1), NULL, $report_start - $report_start_fix),
        );

        $ds = new \PHPExcel_Chart_DataSeries(
            \PHPExcel_Chart_DataSeries::TYPE_PIECHART,
            NULL,
            range(0, count($dsv) - 1),
            $dsl,
            $xal,
            $dsv
        );

        $layout1 = new \PHPExcel_Chart_Layout();
        $layout1->setShowVal(false);
        $layout1->setShowPercent(TRUE);

        $pa = new \PHPExcel_Chart_PlotArea($layout1, array($ds));
        $title = new \PHPExcel_Chart_Title('การทำงานของทีม Support & Helpdesk');
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

        $chart = new \PHPExcel_Chart(
            'chart1',
            $title,
            $legend,
            $pa,
            true,
            0,
            NULL,
            NULL
        );

        $chart->setTopLeftPosition('D' . $report_start_fix);
        $chart->setBottomRightPosition('M108');

        return $chart;
    }

    private function add_system_chart()
    {
        $dsl = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$b$41', NULL, 1),
        );
        $xal = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$42:$A$83', NULL, 42),
        );
        $dsv = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Report!$B$42:$B$83', NULL, 42),
        );

        $ds = new \PHPExcel_Chart_DataSeries(
            \PHPExcel_Chart_DataSeries::TYPE_PIECHART,
            NULL,
            range(0, count($dsv) - 1),
            $dsl,
            $xal,
            $dsv
        );

        $layout1 = new \PHPExcel_Chart_Layout();
        $layout1->setShowVal(false);
        $layout1->setShowPercent(TRUE);

        $pa = new \PHPExcel_Chart_PlotArea($layout1, array($ds));
        $title = new \PHPExcel_Chart_Title('ระบบงาน');
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

        $chart = new \PHPExcel_Chart(
            'chart1',
            $title,
            $legend,
            $pa,
            true,
            0,
            NULL,
            NULL
        );

        $chart->setTopLeftPosition('D41');
        $chart->setBottomRightPosition('M65');

        return $chart;
    }

    private function add_closed_active_chart()
    {
        $dsl = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$b$28', NULL, 1),
        );
        $xal = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$29:$A$30', NULL, 2),
        );
        $dsv = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Report!$B$29:$B$30', NULL, 2),
        );

        $ds = new \PHPExcel_Chart_DataSeries(
            \PHPExcel_Chart_DataSeries::TYPE_PIECHART,
            NULL,
            range(0, count($dsv) - 1),
            $dsl,
            $xal,
            $dsv
        );

        $layout1 = new \PHPExcel_Chart_Layout();
        $layout1->setShowVal(false);
        $layout1->setShowPercent(TRUE);

        $pa = new \PHPExcel_Chart_PlotArea($layout1, array($ds));
        $title = new \PHPExcel_Chart_Title('ลักษณะงาน');
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

        $chart = new \PHPExcel_Chart(
            'chart1',
            $title,
            $legend,
            $pa,
            true,
            0,
            NULL,
            NULL
        );

        $chart->setTopLeftPosition('D28');
        $chart->setBottomRightPosition('M38');

        return $chart;
    }

    private function add_call_category_chart()
    {
        $dsl = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$b$3', NULL, 1),
        );
        $xal = array(
            new \PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$4:$A$17', NULL, 14),
        );
        $dsv = array(
            new \PHPExcel_Chart_DataSeriesValues('Number', 'Report!$B$4:$B$17', NULL, 14),
        );

        $ds = new \PHPExcel_Chart_DataSeries(
            \PHPExcel_Chart_DataSeries::TYPE_PIECHART,
            NULL,
            range(0, count($dsv) - 1),
            $dsl,
            $xal,
            $dsv
        );

        $layout1 = new \PHPExcel_Chart_Layout();
        $layout1->setShowVal(false);
        $layout1->setShowPercent(TRUE);

        $pa = new \PHPExcel_Chart_PlotArea($layout1, array($ds));
        $title = new \PHPExcel_Chart_Title('ลักษณะกลุ่มปัญหา');
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

        $chart = new \PHPExcel_Chart(
            'chart1',
            $title,
            $legend,
            $pa,
            true,
            0,
            NULL,
            NULL
        );

        $chart->setTopLeftPosition('D3');
        $chart->setBottomRightPosition('M25');

        return $chart;
    }

    // private function datediff($date1, $date2)
    // {
    //     $diff = abs(strtotime($date1) - strtotime($date2));

    //     return sprintf(
    //         "%d Days, %s:%s:%s",
    //         intval($diff / 86400),
    //         str_pad(intval(($diff % 86400) / 3600), 2, '0', STR_PAD_LEFT),
    //         str_pad(intval(($diff / 60) % 60), 2, '0', STR_PAD_LEFT),
    //         str_pad(intval($diff % 60), 2, '0', STR_PAD_LEFT)
    //     );
    // }

    private function getExcelColumn()
    {
        $col = [
            0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd', 4 => 'e', 5 => 'f', 6 => 'g', 7 => 'h', 8 => 'i', 9 => 'j',
            10 => 'k', 11 => 'l', 12 => 'm', 13 => 'n', 14 => 'o', 15 => 'p', 16 => 'q', 17 => 'r', 18 => 's', 19 => 't',
            20 => 'u', 21 => 'v', 22 => 'w', 23 => 'x', 24 => 'y', 25 => 'z', 26 => 'aa', 27 => 'ab', 28 => 'ac', 29 => 'ad',
            30 => 'ae', 31 => 'af', 32 => 'ag', 33 => 'ah', 34 => 'ai', 35 => 'aj', 36 => 'ak', 37 => 'al', 38 => 'am', 39 => 'an',
            40 => 'ao', 41 => 'ap', 42 => 'aq', 43 => 'ar', 44 => 'as', 45 => 'at', 46 => 'au', 47 => 'av', 48 => 'aw', 49 => 'ax',
            50 => 'ay', 51 => 'az'
        ];

        return $col;
    }

    private function queryData($request)
    {
        $jobs = null;

        if ($request->get('job') == 'closed') {
            $jobs = Job::where('closed', true);
        } elseif ($request->get('job') == 'all') {
            $jobs = Job::where('id', '>', 0);
        } else {
            $jobs = Job::where('cc_confirm_closed', false);
        }

        if ($request->user()->team == 'DOL') {
            // $dolUsers = User::where('team', 'DOL')->get();
            // $dolUsersArray = [];

            // foreach ($dolUsers as $dolUser) {
            //     array_push($dolUsersArray, $dolUser->id);
            // }

            // $jobs = $jobs->whereIn('create_user_id', $dolUsersArray);
            $jobs = $jobs->where('description', 'not like','%FIXTRAN%');
            $jobs = $jobs->where('description', 'not like','%STRUCTURE%');
        }


        if ($request->get('active_user')) {
            if ($request->get('job') == 'closed') {
                $jobs = $jobs->where('last_operator_id', '=', $request->get('active_user'));
            } else if ($request->get('job') == 'active') {
                $jobs = $jobs->where('active_operator_id', '=', $request->get('active_user'));
            }else{
                $jobs = $jobs->where(function ($query) use ($request) {
                    $query->orWhere(function ($query) use ($request) {
                        $query ->where('active_operator_id', '=',$request->get('active_user'))
                        ->where('active_operator_team', '<>','CC');
                    }) ->orWhere(function ($query) use ($request) {
                       $query ->where('last_operator_id', '=',  $request->get('active_user'))
                        ->where('active_operator_id', '=',null);
                    });
                });

            }
        }

        if (
            $request->user()->team != 'CC'
            and $request->user()->team != 'SP'
            and $request->user()->team != 'OBS'
            and $request->user()->team != 'DOL'
        ) {
            if ($request->get('job') != 'all' and $request->get('job') != 'closed') {
                $jobs = $jobs->where('active_operator_team', $request->user()->team);
            }
        }

        if ($request->user()->team == 'SP' && ($request->get('job') == 'active' || $request->get('job') == '')) {
            $jobs = $jobs->where('closed', false);
        }

        if ($request->user()->team == 'SCS') {
            // $jobs = $jobs->whereHas('scsjob', function ($q) {
            // });
        }

        if ($request->get('from') and $request->get('to')) {
            if ($request->get('from') == $request->get('to')) {
                $jobs = $jobs->whereBetween('created_at', [
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('from') . ' 00.00.00'),
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('from') . ' 23.59.59')
                ]);
            } else {
                $jobs = $jobs->whereBetween('created_at', [
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('from') . ' 00.00.00'),
                    Carbon::createFromFormat('Y-m-d H.i.s', $request->get('to') . ' 23.59.59')
                ]);
            }
        }

        if ($request->get('team')) {
            $jobs = $jobs->where(function ($query) use ($request) {

                $query->where(function ($query) use ($request) {
                    if (strpos($request->get('team'), '-')) {
                        $query->where('closed', true)
                            ->whereIn('last_operator_team', explode('-', $request->get('team')));
                    } else {
                        $query->where('closed', true)
                            ->where('last_operator_team', $request->get('team'));
                    }
                })->orWhere(function ($query) use ($request) {
                    if (strpos($request->get('team'), '-')) {
                        $query->where('closed', false)
                            ->whereIn('active_operator_team', explode('-', $request->get('team')));
                    } else {
                        $query->where('closed', false)
                            ->where('active_operator_team', $request->get('team'));
                    }
                });
            });
        }

        if ($request->get('ticket')) {
            $jobs = $jobs->where('ticket_no', 'like', '%' . $request->get('ticket') . '%');
        }

        if ($request->get('department')) {
            $jobs = $jobs->where('department_id', $request->get('department'));
        }

        if ($request->get('description')) {
            $jobs = $jobs->where('description', 'like', '%' . $request->get('description') . '%');
        }

        if ($request->get('project')) {
            $jobs = $jobs->where('phase', $request->get('project'));
        }

        if ($request->get('system')) {
            $jobs = $jobs->where('last_primary_system_id', $request->get('system'));
        }

        if ($request->get('call_category')) {
            $jobs = $jobs->where('last_call_category_id', $request->get('call_category'));
        }

        if ($request->get('informer_name')) {
            $jobs = $jobs->where('informer_name', 'like', '%' . $request->get('informer_name') . '%');
        }

        if ($request->get('informer_phone_number')) {
            $jobs = $jobs->where('informer_phone_number', 'like', '%' . $request->get('informer_phone_number') . '%');
        }

        return $jobs;
    }

    // auth

    private function showAuth($request, $job)
    {
        return true;
    }

    private function editAuth($request, $job)
    {
        if ($job->cc_confirm_closed == true) return false;

        $jobStack = JobStack::Top($job)->first();

        if ($request->user()->id) {
            try {
                if ($request->user()->id == $jobStack->user_id) {
                    return true;
                } else {
                    return false;
                }
                // return true;
            } catch (\Exception $e) {
                if ($e->getMessage() == 'Trying to get property of non-object') {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    private function deleteAuth($request, $job)
    {
        if ($request->user()->team != 'CC' and $request->user()->team != 'DOL') return false;
        if ($job->cc_confirm_closed == true) return false;

        $jobStack = JobStack::Top($job)->first();

        if ($jobStack) {
            if ($request->user()->id == $jobStack->user_id and $jobStack->stack_number == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function rejectAuth($request, $job)
    {
        if ($request->user()->id == $job->active_operator_id) {
            return true;
        } else {
            $jobStack = JobStack::Top($job)->first();

            if ($jobStack) {
                if ($request->user()->id == $jobStack->user_id) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    private function acceptAuth($request, $job)
    {
        if ($job->cc_confirm_closed == true) return false;

        if ($request->user()->team == $job->active_operator_team and $job->active_operator_id == null) {
            return true;
        } else {
            return false;
        }
    }

    // validate

    private function validateCC(Request $request)
    {
        if ($request->get('tier1_solve_result') == null) {
            return 'ต้องระบุผลการแก้ไข';
        } elseif (
            $request->get('tier1_solve_result') == '1'
            and $request->get('tier1_forward') !== null
        ) {
            return 'หากแก้ไขได้ ต้องไม่มีการส่งต่อ';
        } elseif (
            $request->get('tier1_solve_result') == '0'
            and $request->get('tier1_forward') == null
        ) {
            return 'หากแก้ไม่ได้ ต้องมีการส่งต่อ';
        } elseif (
            $request->get('tier1_forward') != 'SP'
            and $request->get('tier1_forward') != 'SA'
            and $request->get('tier1_forward') != 'NW'
            and $request->get('tier1_forward') != 'ST'
            and $request->get('tier1_forward') != 'SCS'
            and $request->get('tier1_forward') !== null
        ) {
            return 'การส่งต่อมีแค่ SA NW ST SCS';
        } else {
            return 'pass';
        }
    }

    private function validateCCSCS(Request $request)
    {
        if ($request->get('serial_number') == null) {
            return 'ต้องระบุหมายเลขอุปกรณ์';
        } elseif ($request->get('product') == null) {
            return 'ต้องระบุชนิดอุปกรณ์';
        } elseif ($request->get('hw_search_result_val') == '0') {
            return 'ไม่พบรายการอุปกรณ์ในระบบ';
        } else {
            return 'pass';
        }
    }

    private function validateSCS(Request $request)
    {
        if ($request->get('scs_action') == null) {
            return 'ต้องระบุการดำเนินการแก้ไข';
        } elseif ($request->get('scs_start_dtm') == null) {
            return 'ต้องระบุเวลาที่เริ่มแก้ไข';
        } elseif ($request->get('scs_action_dtm') == null) {
            return 'ต้องระบุเวลาที่แก้ไขเสร็จ';
        } else {
            return 'pass';
        }
    }

    private function validateSP(Request $request)
    {
        if (
            $request->get('tier2_solve_result') == null
            and $request->get('tier2_forward') !== null
        ) {
            return 'หากมีการส่งต่อ ต้องระบุผลการแก้ไข';
        } elseif (
            $request->get('tier2_solve_result') == '1'
            and $request->get('tier2_forward') !== null
        ) {
            return 'หากแก้ไขได้ ต้องไม่มีการส่งต่อ';
        } elseif (
            $request->get('tier2_solve_result') == '0'
            and $request->get('tier2_forward') == null
        ) {
            return 'หากแก้ไขไม่ได้ ต้องมีการส่งต่อ';
        } elseif (
            $request->get('tier2_forward') != 'SA'
            and $request->get('tier2_forward') != 'NW'
            and $request->get('tier2_forward') != 'ST'
            and $request->get('tier2_forward') != 'SCS'
            and $request->get('tier2_forward') !== null
        ) {
            return 'การส่งต่อมีแค่ SA NW ST SCS';
        } elseif (empty($request->get('tier2_solve_description'))) {
            return 'ต้องบันทึกผลการแก้ไข';
        } else {
            return 'pass';
        }
    }

    private function validateSANWST(Request $request)
    {
        if (
            $request->get('tier3_solve_result') == null
            and $request->get('tier3_forward') !== null
        ) {
            return 'หากมีการส่งต่อ ต้องระบุผลการแก้ไข';
        } elseif (
            $request->get('tier3_solve_result') == '1'
            and $request->get('tier3_forward') !== null
        ) {
            return 'หากแก้ไขได้ ต้องไม่มีการส่งต่อ';
        } elseif (
            $request->get('tier3_solve_result') == '0'
            and $request->get('tier3_forward') == null
        ) {
            return 'หากแก้ไขไม่ได้ ต้องมีการส่งต่อ';
        } elseif (
            $request->get('tier3_forward') != 'SCS'
            and $request->get('tier3_forward') !== null
        ) {
            return 'การส่งต่อมีแค่ SCS';
        } elseif (empty($request->get('tier3_solve_description'))) {
            return 'ต้องบันทึกผลการแก้ไข';
        } else {
            return 'pass';
        }
    }

    // save data

    private function saveDataCC($request, $job)
    {
        $job->department_id = $request->get('department');
        $job->informer_name = $request->get('informer_name');
        $job->informer_phone_number = $request->get('informer_phone_number');

        if ($request->user()->team == 'DOL') {
            $job->informer_type = 'C';
        } else {
            $job->informer_type = $request->get('informer_type');
        }

        $job->sw_version = $request->get('sw_version');
        $job->description = $request->get('description');

        if ($request->get('call_category')) {
            $job->call_category_id = $job->last_call_category_id = $request->get('call_category');
        }

        $job->counter = $request->get('counter');
        $job->screen_id = $request->get('screen_id');
        $job->return_job = $request->get('return_job') ? $request->get('return_job') : false;
        $job->tier1_solve_description = $request->get('tier1_solve_description');
        $job->tier1_solve_result = $request->get('tier1_solve_result');
        $job->last_operator_id = $request->user()->id;
        $job->last_operator_team = $request->user()->team;
        $job->remark = $request->get('remark');
        $job->active_operator_id = null;

        if ($job->tier1_solve_result) {
            $job->closed = true;
            $job->closed_at = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
            $job->cc_confirm_closed_id = $request->user()->id;
            $job->cc_confirm_closed = true;
            $job->cc_confirm_closed_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
            $job->tier1_forward = null;
            $job->active_operator_team = null;
        } else {
            $job->closed = false;
            $job->closed_at = null;
            $job->cc_confirm_closed_id = null;
            $job->cc_confirm_closed = false;
            $job->cc_confirm_closed_dtm = null;
            $job->tier1_forward = $request->get('tier1_forward');

            if ($request->get('tier1_forward') == 'SCS') {
                $job->active_operator_team = 'CC';
            } else {
                $job->active_operator_team = $request->get('tier1_forward');
            }
        }

        $department = Department::findOrFail($request->get('department'));
        $job->phase = $department->phase;

        if ($department->phase == 1) {
            if ($request->get('primary_system_ph1')) {
                $job->primary_system_id = $job->last_primary_system_id = $request->get('primary_system_ph1');
            }

            if ($request->get('secondary_system_ph1')) {
                $job->secondary_system_id = $job->last_secondary_system_id = $request->get('secondary_system_ph1');
            }
        } elseif ($department->phase == 2) {
            if ($request->get('primary_system_ph2')) {
                $job->primary_system_id = $job->last_primary_system_id = $request->get('primary_system_ph2');
            }

            if ($request->get('secondary_system_ph2')) {
                $job->secondary_system_id = $job->last_secondary_system_id = $request->get('secondary_system_ph2');
            }
        } elseif ($department->phase == 3) {
            if ($request->get('primary_system_ph3')) {
                $job->primary_system_id = $job->last_primary_system_id = $request->get('primary_system_ph3');
            }

            if ($request->get('secondary_system_ph3')) {
                $job->secondary_system_id = $job->last_secondary_system_id = $request->get('secondary_system_ph3');
            }
        } elseif ($department->phase == 4) {
            if ($request->get('primary_system_ph4')) {
                $job->primary_system_id = $job->last_primary_system_id = $request->get('primary_system_ph4');
            }

            if ($request->get('secondary_system_ph4')) {
                $job->secondary_system_id = $job->last_secondary_system_id = $request->get('secondary_system_ph4');
            }
        } else {
            if ($request->get('primary_system')) {
                $job->primary_system_id = $job->last_primary_system_id = $request->get('primary_system');
            }

            if ($request->get('secondary_system')) {
                $job->secondary_system_id = $job->last_secondary_system_id = $request->get('secondary_system');
            }
        }

        if (
            $request->get('informer_name') != '-'
            and $request->get('informer_phone_number') != '-'
            and !strpos(strtoupper($request->get('informer_name')), 'LINE')
            and !strpos(strtoupper($request->get('informer_phone_number')), 'LINE')
        ) {

            $informer = Informer::where('name', $request->get('informer_name'))
                ->where('phone_number', $request->get('informer_phone_number'))
                ->where('type', $job->informer_type)
                ->first();

            if (!$informer) {
                $informer = new Informer;
                $informer->name = $request->get('informer_name');
                $informer->phone_number = str_replace('-', '', $request->get('informer_phone_number'));
                $informer->type = $job->informer_type;
                $informer->save();
            }
        }

        return $job;
    }

    private function saveDataCCSCS($request, $job)
    {
        if ($job->scsjob) {
            $scsjob = $job->scsjob;
        } else {
            $scsjob = new ScsJob;
        }
        $scsjob->job_id = $job->id;
        //serial_number is id
        $hw = HardwareItem::where('serial_number', $request->get('serial_number'))->first();
        if ($hw) {
            //$scsjob->hw_id = $hw->serial_number;
            $scsjob->serial_number = $hw->serial_number;
            $scsjob->hw_id = $hw->id;

        }
       // $scsjob->hw_id = $request->get('serial_number');
        $scsjob->product = $request->get('product');
        // $scsjob->serial_number = $request->get('serial_number');
        $scsjob->model_part_number = $request->get('model_part_number');
        $scsjob->malfunction = $request->get('malfunction');
        $scsjob->create_user_id = $request->user()->id;

        // if ($job->phase == '1') {
        //     $hw = Ph1HardwareItem::where('serial_number', $request->get('serial_number'))->first();
        //     if ($hw) {
        //         $scsjob->hw_ph1_id = $hw->id;
        //     }
        // } elseif ($job->phase == '2') {
        //     $hw = Ph2HardwareItem::where('serial_number', $request->get('serial_number'))->first();
        //     if ($hw) {
        //         $scsjob->hw_ph2_id = $hw->id;
        //     }
        // }



        $scsjob->save();

        // send mail
        // $filename = 'Open ' . date('Y-m-d') . '_' . $job->ticket_no . '_' . $job->department->name;

        // Excel::create($filename, function ($excel) use ($job, $scsjob) {
        //     $excel->sheet('Sheet1', function ($sheet) use ($job, $scsjob) {
        //         $sheet->loadView('scs_job.excel', [
        //             'job' => $job,
        //             'scs' => $scsjob,
        //         ]);
        //     });
        // })->store('xlsx', storage_path('excel/exports'));

        // if (strpos($request->user()->email, '@calllog.samart.online')) {
        //     Mail::send('scs_job.mail', [], function ($m) use ($request, $filename, $job) {
        //         $m->subject($filename);
        //         $m->to('pkxiii@gmail.com', 'pkxiii@gmail.com');
        //         $m->attach(storage_path('excel/exports') . '/' . $filename . '.xlsx');
        //     });
        // } else {
        //     Mail::send('scs_job.mail', [], function ($m) use ($request, $filename, $job) {
        //         $m->subject($filename);
        //         $m->to('noc@samtel.samartcorp.com', 'noc@samtel.samartcorp.com');
        //         $m->to('Helpdesk.dol57@yahoo.co.th', 'Helpdesk.dol57@yahoo.co.th');
        //         $m->cc('suntachotpop@gmail.com', 'suntachotpop@gmail.com');
        //         $m->attach(storage_path('excel/exports') . '/' . $filename . '.xlsx');
        //     });
        // }

        // if ($request->get('tier1_forward') == 'SCS') {
        //     $job->active_operator_team = 'CC';
        // } else {
        //     $job->active_operator_team = $request->get('tier1_forward');
        // }

        $job->active_operator_team = 'SCS';
        $job->active_operator_id = null;

        return $job;
    }

    private function saveDataSP($request, $job)
    {
        $job->tier2_solve_description = $request->get('tier2_solve_description');
        $job->remark = $request->get('remark');

        if (
            $request->get('tier2_solve_result') == null
            and $request->get('tier2_forward') == null
        ) {
            $job->tier2_solve_result = null;
            $job->tier2_forward = null;
            $job->active_operator_team = 'SP';
            $job->active_operator_id = $request->user()->id;
            $job->closed = false;
            $job->closed_at = null;
        } else {
            $job->tier2_solve_result = $request->get('tier2_solve_result');
            $job->tier2_solve_result_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');

            if ($request->get('tier2_solve_result')) {
                $job->closed = true;
                $job->closed_at = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
                $job->active_operator_team = null;
                $job->tier2_forward = null;
            } else {
                $job->closed = false;
                $job->closed_at = null;
                $job->tier2_forward = $request->get('tier2_forward');

                if ($request->get('tier2_forward') == 'SCS') {
                    $job->active_operator_team = 'CC';
                } else {
                    $job->active_operator_team = $request->get('tier2_forward');
                }
            }

            $job->active_operator_id = null;
            $job->last_operator_id = $request->user()->id;
            $job->last_operator_team = $request->user()->team;

            if ($request->get('call_category')) {
                $job->call_category_id = $job->last_call_category_id = $request->get('call_category');
            }

            if ($request->get('primary_system')) {
                $job->primary_system_id = $job->last_primary_system_id = $request->get('primary_system');
            }

            if ($request->get('secondary_system')) {
                $job->secondary_system_id = $job->last_secondary_system_id = $request->get('secondary_system');
            }

            //save description
            $solveDesc = SolveDescription::where('phase', $job->phase)
            ->where('tier', '2')
            ->where('description', $request->get('tier2_solve_description'))
            ->first();

            if (!$solveDesc) {
                $solveDescription = new SolveDescription;
                $solveDescription->description = preg_replace("/\r|\n/", "", $request->get('tier2_solve_description'));
                $solveDescription->phase = $job->phase;
                $solveDescription->tier = '2';
                $solveDescription->save();
            }
        }

        return $job;
    }

    private function saveDataSA($request, $job)
    {
        if (
            $request->get('tier3_solve_result') == null
            and $request->get('tier3_forward') == null
        ) {
            $job->tier3_solve_description = $request->get('tier3_solve_description');
            $job->tier3_solve_result = null;
            $job->tier3_forward = null;
            $job->active_operator_team = 'SA';
            $job->active_operator_id = $request->user()->id;
            $job->closed = false;
            $job->closed_at = null;
        } else {
            $job->tier3_solve_description = $request->get('tier3_solve_description');
            $job->tier3_solve_result = $request->get('tier3_solve_result');
            $job->tier3_solve_result_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');

            if ($request->get('tier3_solve_result')) {
                $job->closed = true;
                $job->closed_at = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
                $job->active_operator_team = null;
                $job->tier3_forward = null;
            } else {
                $job->closed = false;
                $job->closed_at = null;
                $job->tier3_forward = $request->get('tier3_forward');

                if ($request->get('tier3_forward') == 'SCS') {
                    $job->active_operator_team = 'CC';
                } else {
                    $job->active_operator_team = $request->get('tier3_forward');
                }
            }

            $job->active_operator_id = null;
            $job->last_operator_id = $request->user()->id;
            $job->last_operator_team = $request->user()->team;
        }

        $job = $this->saveDataSARW($request, $job);

        return $job;
    }

    private function saveDataNWST($request, $job)
    {
        if (
            $request->get('tier3_solve_result') == null
            and $request->get('tier3_forward') == null
        ) {
            $job->tier3_solve_description = $request->get('tier3_solve_description');
            $job->tier3_solve_result = null;
            $job->tier3_forward = null;
            $job->active_operator_team = $request->user()->team;
            $job->active_operator_id = $request->user()->id;
            $job->closed = false;
            $job->closed_at = null;
        } else {
            $job->tier3_solve_description = $request->get('tier3_solve_description');
            $job->tier3_solve_result = $request->get('tier3_solve_result');
            $job->tier3_solve_result_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');

            if ($request->get('tier3_solve_result')) {
                $job->closed = true;
                $job->closed_at = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
                $job->active_operator_team = null;
                $job->tier3_forward = null;
            } else {
                $job->closed = false;
                $job->closed_at = null;
                $job->tier3_forward = $request->get('tier3_forward');

                if ($request->get('tier3_forward') == 'SCS') {
                    $job->active_operator_team = 'CC';
                } else {
                    $job->active_operator_team = $request->get('tier3_forward');
                }
            }

            $job->active_operator_id = null;
            $job->last_operator_id = $request->user()->id;
            $job->last_operator_team = $request->user()->team;
        }

        return $job;
    }

    private function saveDataSCS($request, $job)
    {
        $scsjob = $job->scsjob;
        $scsjob->action = $request->get('scs_action');
        $scsjob->start_dtm = $request->get('scs_start_dtm');
        $scsjob->action_dtm = $request->get('scs_action_dtm');
        $scsjob->operator_name = $request->get('operator_name');
        $scsjob->cause = $request->get('scs_cause');
        $scsjob->remark = $request->get('scs_remark');
        $scsjob->save();

        $job->closed = true;
        $job->closed_at = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');
        $job->last_operator_id = $request->user()->id;
        $job->last_operator_team = $request->user()->team;
        $job->active_operator_id = null;
        $job->active_operator_team = null;
        $job->scs_solve_result_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');

        // send mail
        // $filename = 'Close ' . date('Y-m-d') . '_' . $job->ticket_no . '_' . $job->department->name;

        // Excel::create($filename, function ($excel) use ($job, $scsjob) {
        //     $excel->sheet('Sheet1', function ($sheet) use ($job, $scsjob) {
        //         $sheet->loadView('scs_job.excel', [
        //             'job' => $job,
        //             'scs' => $scsjob,
        //         ]);
        //     });
        // })->store('xlsx', storage_path('excel/exports'));

        // if (strpos($request->user()->email, '@calllog.samart.online')) {
        //     Mail::send('scs_job.mail', [], function ($m) use ($request, $filename, $job) {
        //         $m->subject($filename);
        //         $m->to('pkxiii@gmail.com', 'pkxiii@gmail.com');
        //         $m->attach(storage_path('excel/exports') . '/' . $filename . '.xlsx');
        //     });
        // } else {
        //     Mail::send('scs_job.mail', [], function ($m) use ($request, $filename, $job) {
        //         $m->subject($filename);
        //         $m->to('noc@samtel.samartcorp.com', 'noc@samtel.samartcorp.com');
        //         $m->to('Helpdesk.dol57@yahoo.co.th', 'Helpdesk.dol57@yahoo.co.th');
        //         $m->cc('suntachotpop@gmail.com', 'suntachotpop@gmail.com');
        //         $m->cc('chatchai.k@samtel.samartcorp.com', 'chatchai.k@samtel.samartcorp.com');
        //         $m->attach(storage_path('excel/exports') . '/' . $filename . '.xlsx');
        //     });
        // }

        return $job;
    }

    private function saveDataSARW($request, $job)
    {
        if ($request->get('sa_rw')) {
            $job->sa_rw = true;
            $job->sa_rw_id = $request->user()->id;
            $job->sa_rw_dtm = DB::raw('DATE_ADD(NOW(), INTERVAL 7 HOUR)');

            if ($request->get('sa_rw_call_category')) {
                $job->sa_rw_call_category_id = $job->last_call_category_id = $request->get('sa_rw_call_category');
            }

            if ($request->get('sa_rw_primary_system')) {
                $job->sa_rw_primary_system_id = $job->last_primary_system_id = $request->get('sa_rw_primary_system');
            }

            if ($request->get('sa_rw_secondary_system')) {
                $job->sa_rw_secondary_system_id = $job->last_secondary_system_id = $request->get('sa_rw_secondary_system');
            }

            $job->sa_rw_return_job = $request->get('sa_rw_return_job');
            $job->sa_rw_remark = $request->get('sa_rw_remark');
        } else {
            $job->sa_rw = false;
            $job->sa_rw_call_category_id = null;
            $job->last_call_category_id = $job->call_category_id;
            $job->sa_rw_primary_system_id = null;
            $job->last_primary_system_id = $job->primary_system_id;
            $job->sa_rw_secondary_system_id = null;
            $job->last_secondary_system_id = $job->secondary_system_id;
            $job->sa_rw_return_job = null;
            $job->sa_rw_remark = null;
        }

        return $job;
    }
}
