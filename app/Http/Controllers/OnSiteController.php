<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\Environment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Job;
use App\JobStack;
use App\Department;
use Carbon\Carbon;
use App\Traits\queryAlmostDataTrait;
use App\Traits\dateDiffTrait;
use App\Traits\excelColumnTrait;

use Excel;

class OnSiteController extends Controller
{
    use queryAlmostDataTrait;
    use dateDiffTrait;
    use excelColumnTrait;

    public function index(Request $request){

        // $overIn = $this->queryDataOver($department, $project, 0);
        // $overEnd = $this->queryDataOver($department, $project, 1);
                
        // $overIn = $overIn->paginate(10, ['*'], 'overIn');
        // $overEnd = $overEnd->paginate(10, ['*'], 'overEnd');

        // $cAlomostIn = $this->queryDataAlmost($department,$project,0)->count();
        // $cAlomostEnd = $this->queryDataAlmost($department,$project,1)->count();


        $in24 = $this->queryData($request, 0);
        $in48 = $this->queryData($request, 1);
        $over48 = $this->queryData($request, 2);

        $in24 = $in24->paginate(10, ['*'], 'in24');
        $in48 = $in48->paginate(10, ['*'], 'in48');
        $over48 = $over48->paginate(10, ['*'], 'over48');

        // print_r($in48);
        
        return view('onsite.index')
                ->with('in24',$in24)
                ->with('in48',$in48)
                ->with('over48',$over48)
                ->with('departments',Department::all());
    }

    public function exportExcel(Request $request) {
        $department = !empty($request->department)? $request->department : "";
        $project = !empty($request->project)? $request->project : "";

        $dpName = "";
        if($department != ""){
            $dp = Department::find($department);
            $dpName .= $dp->name.' ';
        } 
        $filename = 'Onsite_SLA '. $dpName . date('Y-m-d');

        $excOnsite = new \PHPExcel();
        $col = $this->getExcelColumn();
        $c = 0;
        $row = 1;
        $nc = 8;

        $sla_24hr = $excOnsite->getSheet(0);
        $sla_24hr->setTitle('sla_over24hr');

        // //header
        $overIn = $this->queryDataOver($department, $project, 0)->get();
        
        $sla_24hr->mergeCells($col[$c].$row. ":" .$col[$nc].$row);
        $sla_24hr->setCellValue($col[$c] . $row, $dpName . date('d M Y'));

        $row++;
        $sla_24hr->setCellValue($col[$c++] . $row, 'Ticket No.');
        $sla_24hr->setCellValue($col[$c++] . $row, 'วัน-เวลา');
        $sla_24hr->setCellValue($col[$c++] . $row, 'หน่วยงาน');
        $sla_24hr->setCellValue($col[$c++] . $row, 'ชื่อผู้แจ้ง');
        $sla_24hr->setCellValue($col[$c++] . $row, 'รายละเอียดปัญหา');
        $sla_24hr->setCellValue($col[$c++] . $row, 'ผู้ดูแล');
        $sla_24hr->setCellValue($col[$c++] . $row, 'สถานะ');
        $sla_24hr->setCellValue($col[$c++] . $row, 'วันเวลาที่รับเรื่อง');
        $sla_24hr->setCellValue($col[$c++] . $row, 'ระยะเวลาที่ใช้ในการรับเรื่อง');
        // $sla_24hr->setCellValue($col[$c++] . $row, 'ระยะเวลาที่ใช้ในการดำเนินการ');
        // $sla_24hr->setCellValue($col[$c++] . $row, 'ระยะเวลาที่ใช้ทั้งหมด');

        foreach ($overIn as $in){
            $row++;
            $c = 0;

            $sla_24hr->setCellValue($col[$c++] . $row, $in->ticket_no);
            $sla_24hr->setCellValue($col[$c++] . $row, $in->created_at);
            $sla_24hr->setCellValue($col[$c++] . $row, $in->department->name);
            $sla_24hr->setCellValue($col[$c++] . $row, $in->informer_name);
            $sla_24hr->setCellValue($col[$c++] . $row, $in->description);

            $op = '['.($in->closed==0? $in->active_operator_team : $in->last_operator_team).'] ';
            $op .= ($in->closed==0?  empty($in->active_operator->name)? "": $in->active_operator->name : (empty($in->last_operator->name)? "": $in->last_operator->name));
            $sla_24hr->setCellValue($col[$c++] . $row, $op);

            if($in->closed == true and $in->cc_confirm_closed == true)
                $sts = 'Closed'; 
            elseif($in->closed == true and $in->cc_confirm_closed == false)
                $sts = 'Confirm'; 
            else
                $sts = 'Active';
            $sla_24hr->setCellValue($col[$c++] . $row, $sts);
            $sla_24hr->setCellValue($col[$c++] . $row, $in->scs_solve_user_dtm);
            $sla_24hr->setCellValue($col[$c++] . $row, $in->scs_solve_user_dtm==""? "": $this->datediff($in->scs_solve_user_dtm,$in->created_at));
            // $sla_24hr->setCellValue($col[$c++] . $row, $in->closed==0? "": $this->datediff($in->closed_at,$in->scs_solve_user_dtm));
            // $sla_24hr->setCellValue($col[$c++] . $row, $in->closed==0? "": $this->datediff($in->closed_at,$in->created_at));

            if ($in->closed_at == null) {
                $sla_24hr->getStyle($col[0] . $row . ':' . $col[$c - 1] . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                        ),
                    )
                );
            }

            $effect_row = $col[0] . $row . ':' . $col[$c - 1] . $row;

            $sla_24hr->getStyle($effect_row)->getAlignment()->setWrapText(true);
            $sla_24hr->getStyle($effect_row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $sla_24hr->getStyle($effect_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }

        
        $header = 'a1:i2';
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $sla_24hr->getStyle($header)->applyFromArray($style);

        $c = 0;
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_24hr->getColumnDimension($col[$c++])->setWidth(21);
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_24hr->getColumnDimension($col[$c++])->setWidth(60);
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);
        // $sla_24hr->getColumnDimension($col[$c++])->setAutoSize(true);

        $c = 0;
        $row = 1;

        $sla_48hr = $excOnsite->createSheet();
        $sla_48hr = $excOnsite->getSheet(1);
        $sla_48hr->setTitle('sla_over48hr');

        $overEnd = $this->queryDataOver($department, $project, 1)->get();

        $sla_48hr->mergeCells($col[$c].$row. ":" .$col[$nc].$row);
        $sla_48hr->setCellValue($col[$c] . $row, $dpName . date('d M Y'));

        $row++;
        $sla_48hr->setCellValue($col[$c++] . $row, 'Ticket No.');
        $sla_48hr->setCellValue($col[$c++] . $row, 'วัน-เวลา');
        $sla_48hr->setCellValue($col[$c++] . $row, 'หน่วยงาน');
        $sla_48hr->setCellValue($col[$c++] . $row, 'ชื่อผู้แจ้ง');
        $sla_48hr->setCellValue($col[$c++] . $row, 'รายละเอียดปัญหา');
        $sla_48hr->setCellValue($col[$c++] . $row, 'ผู้ดูแล');
        $sla_48hr->setCellValue($col[$c++] . $row, 'สถานะ');
        // $sla_48hr->setCellValue($col[$c++] . $row, 'ระยะเวลาที่ใช้ในการรับเรื่อง');
        // $sla_48hr->setCellValue($col[$c++] . $row, 'ระยะเวลาที่ใช้ในการดำเนินการ');
        $sla_48hr->setCellValue($col[$c++] . $row, 'วันเวลาที่ดำเนินการแล้วเสร็จ');
        $sla_48hr->setCellValue($col[$c++] . $row, 'ระยะเวลาที่ใช้ทั้งหมด');

        foreach ($overEnd as $end){
            $row++;
            $c = 0;

            $sla_48hr->setCellValue($col[$c++] . $row, $end->ticket_no);
            $sla_48hr->setCellValue($col[$c++] . $row, $end->created_at);
            $sla_48hr->setCellValue($col[$c++] . $row, $end->department->name);
            $sla_48hr->setCellValue($col[$c++] . $row, $end->informer_name);
            $sla_48hr->setCellValue($col[$c++] . $row, $end->description);

            $op = '['.($end->closed==0? $end->active_operator_team : $end->last_operator_team).'] ';
            $op .= ($end->closed==0?  empty($end->active_operator->name)? "": $end->active_operator->name : (empty($end->last_operator->name)? "": $end->last_operator->name));
            $sla_48hr->setCellValue($col[$c++] . $row, $op);

            if($end->closed == true and $end->cc_confirm_closed == true)
                $sts = 'Closed'; 
            elseif($end->closed == true and $end->cc_confirm_closed == false)
                $sts = 'Confirm'; 
            else
                $sts = 'Active';
            $sla_48hr->setCellValue($col[$c++] . $row, $sts);
            $sla_48hr->setCellValue($col[$c++] . $row, $end->action_dtm);
            // $sla_48hr->setCellValue($col[$c++] . $row, $end->scs_solve_user_dtm==""? "": $this->datediff($end->scs_solve_user_dtm,$end->created_at));
            // $sla_48hr->setCellValue($col[$c++] . $row, $end->closed==0? "": $this->datediff($end->action_dtm,$end->scs_solve_user_dtm));
            $sla_48hr->setCellValue($col[$c++] . $row, $end->closed==0? "": $this->datediff($end->action_dtm,$end->created_at));

            if ($end->closed_at == null) {
                $sla_48hr->getStyle($col[0] . $row . ':' . $col[$c - 1] . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                        ),
                    )
                );
            }

            $effect_row = $col[0] . $row . ':' . $col[$c - 1] . $row;

            $sla_48hr->getStyle($effect_row)->getAlignment()->setWrapText(true);
            $sla_48hr->getStyle($effect_row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $sla_48hr->getStyle($effect_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }

        $header = 'a1:i2';
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $sla_48hr->getStyle($header)->applyFromArray($style);

        $c = 0;
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_48hr->getColumnDimension($col[$c++])->setWidth(21);
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_48hr->getColumnDimension($col[$c++])->setWidth(60);
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);
        // $sla_48hr->getColumnDimension($col[$c++])->setAutoSize(true);

        $writer = \PHPExcel_IOFactory::createWriter($excOnsite, 'Excel2007');
        $writer->setIncludeCharts(true);

        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        $writer->save('php://output');

        // return view('onsite.test')
        //     ->with('overIn',$overIn);

    }

    /*
    fn queryDataOver
    @param $department = department_id
    @param $project = [1=>DOL1, 2=>DOL2, 4=>DOL4]
    @param $sts = [0=>24hr, 1=>48hr]
    @return $data
    */
    public function queryDataOver($department, $project, $sts){
        $data;
        if($sts == 0){
            $data = Job::leftjoin('scs_jobs','jobs.id','=','scs_jobs.job_id')
                ->where(function($query) use ($department,$project){
                    $query->where(function($query) use ($department,$project){
                        $query->where('closed','=','0')
                            ->whereNull('scs_solve_user_dtm')
                            ->where('call_category_id','=','5')
                            ->whereRaw('NOW() > Date_Add(jobs.created_at, INTERVAL 24 HOUR)');

                        if($department!="") $query->where('department_id','=',$department);
                        if($project!="") $query->where('phase','=',$project);
                    })
                    ->orWhere(function($query) use ($department,$project){
                        $query->whereNotNull('scs_solve_user_dtm')
                            ->whereRaw('scs_solve_user_dtm > Date_Add(jobs.created_at, INTERVAL 24 HOUR)')
                            ->where('call_category_id','=','5');
                        if($department!="") $query->where('department_id','=',$department);
                        if($project!="") $query->where('phase','=',$project);
                    });
                })
                ->orderBy('jobs.created_at','desc');
        } else if ($sts == 1){
            $data = Job::leftjoin('scs_jobs','jobs.id','=','scs_jobs.job_id')
                ->where(function($query) use ($department,$project){
                    $query->where(function($query) use ($department,$project){
                            $query->where('closed','=','0')
                                ->whereNotNull('scs_solve_user_dtm')
                                ->whereRaw('NOW() > Date_Add(jobs.created_at, INTERVAL 48 HOUR)')
                                ->where('call_category_id','=','5');
                            
                            if($department!="") $query->where('department_id','=',$department);
                            if($project!="") $query->where('phase','=',$project);
                        })
                        ->orWhere(function($query) use ($department,$project){
                            $query->where('closed','=','1')
                                ->whereRaw('action_dtm > Date_Add(jobs.created_at, INTERVAL 48 HOUR)')
                                ->where('call_category_id','=','5');
                            if($department!="") $query->where('department_id','=',$department);
                            if($project!="") $query->where('phase','=',$project);
                        });
                })
                ->orderBy('jobs.created_at','desc');
        }

        return $data;
    }

    public function queryData(Request $request, $sts){
        $department = !empty($request->department)? $request->department : "";
        $project = !empty($request->project)? $request->project : "";
        $close = $request->close == 'active'? 0 : ($request->close == 'closed'? 1 : "");
        $jobs = Job::where('call_category_id','=','5')
                ->orderBy('created_at','desc');
        if($department != "") $jobs->where('department_id','=',$department);
        if($project != "") $jobs->where('phase','=',$project);
        if($close !== "") $jobs->where('closed','=',$close);

        if($sts == 0) $jobs->whereRaw('NOW() <= Date_Add(jobs.created_at, INTERVAL 24 HOUR)');
        elseif($sts == 1) $jobs->whereRaw('NOW() > Date_Add(jobs.created_at, INTERVAL 24 HOUR)')
                            ->whereRaw('NOW() <= Date_Add(jobs.created_at, INTERVAL 48 HOUR)');
        elseif($sts == 2) $jobs->whereRaw('NOW() > Date_Add(jobs.created_at, INTERVAL 48 HOUR)');

        return $jobs;
    }

    public function export2 (Request $request){
        $department = !empty($request->department)? $request->department : "";

        $dpName = "";
        if($department != ""){
            $dp = Department::find($department);
            $dpName .= $dp->name.' ';
        } 
        $filename = 'Onsite_SLA '. $dpName . date('Y-m-d');

        $excOnsite = new \PHPExcel();
        $col = $this->getExcelColumn();
        $c = 0;
        $row = 1;
        $nc = 15;

        $works = $excOnsite->getSheet(0);
        $works->setTitle('jobs_onsite');

        // //header
        $jobs = $this->queryData($request, 4)->get();
        
        $works->mergeCells($col[$c].$row. ":" .$col[$nc].$row);
        $works->setCellValue($col[$c] . $row, $dpName . date('d M Y'));

        $row++;
        $works->setCellValue($col[$c++] . $row, 'ลำดับ');
        $works->setCellValue($col[$c++] . $row, 'วัน');
        $works->setCellValue($col[$c++] . $row, 'เวลา');
        $works->setCellValue($col[$c++] . $row, 'หน่วยงาน');
        $works->setCellValue($col[$c++] . $row, 'ชื่อผู้แจ้ง');
        $works->setCellValue($col[$c++] . $row, 'โทร');
        $works->setCellValue($col[$c++] . $row, 'Ticket No.');
        $works->setCellValue($col[$c++] . $row, 'ชื่อผู้รับแจ้ง');
        $works->setCellValue($col[$c++] . $row, 'รายละเอียดปัญหา');
        $works->setCellValue($col[$c++] . $row, 'บันทึกการแก้ปัญหา');
        $works->setCellValue($col[$c++] . $row, 'วันที่แก้ไขเสร็จ');
        $works->setCellValue($col[$c++] . $row, 'เวลาที่แก้ไขเสร็จ');
        $works->setCellValue($col[$c++] . $row, 'เวลาที่ใช้ในการแก้ไข');
        $works->setCellValue($col[$c++] . $row, 'กลุ่มปัญหา');
        $works->setCellValue($col[$c++] . $row, 'ระบบงานหลัก');
        $works->setCellValue($col[$c++] . $row, 'หมายเหตุ');

        
        $n = 1;
        foreach ($jobs as $job){
            $row++;
            $c = 0;

            $works->setCellValue($col[$c++] . $row, $n++);
            $works->setCellValue($col[$c++] . $row, explode(' ', $job->created_at)[0]);
            $works->setCellValue($col[$c++] . $row, explode(' ', $job->created_at)[1]);
            $works->setCellValue($col[$c++] . $row, $job->department->name);
            $works->setCellValue($col[$c++] . $row, $job->informer_name);
            $works->setCellValue($col[$c++] . $row, $job->informer_phone_number);
            // $works->setCellValue($col[$c++] . $row, str_pad($job->informer_phone_number, 10, '0', STR_PAD_LEFT));
            $works->setCellValue($col[$c++] . $row, $job->ticket_no);
                $user = JobStack::where('job_id','=',$job->id)
                                ->where('stack_number','=','1')
                                ->first();
            $works->setCellValue($col[$c++] . $row, $user->user->name);
            $works->setCellValue($col[$c++] . $row, $job->description);
                $cause = "";
                $cause .= empty($job->scsjob->cause)? "": $job->scsjob->cause;
                $cause .= empty($job->scsjob->action)? "": " \n " . $job->scsjob->action;
            $works->setCellValue($col[$c++] . $row, $cause);
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->action_dtm)? "" : explode(' ',$job->scsjob->action_dtm)[0]);
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->action_dtm)? "" : explode(' ',$job->scsjob->action_dtm)[1]);
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->action_dtm)? "" : $this->datediff($job->scsjob->action_dtm,$job->created_at));
            $works->setCellValue($col[$c++] . $row, $job->call_category->ploblem_group);
            $works->setCellValue($col[$c++] . $row, empty($job->primary_system->flag)? "": $job->primary_system->flag);
            $works->setCellValue($col[$c++] . $row, $job->remark);

            

            if ($job->closed_at == null) {
                $works->getStyle($col[0] . $row . ':' . $col[$c - 1] . $row)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FFFF00')
                        ),
                    )
                );
            }

            $effect_row = $col[0] . $row . ':' . $col[$c - 1] . $row;

            
            $works->getStyle($col[5].$row)->getNumberFormat()->setFormatCode('0000000000');
            $works->getStyle($effect_row)->getAlignment()->setWrapText(true);
            $works->getStyle($effect_row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $works->getStyle($col[5].$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $works->getStyle($effect_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        $header = 'a1:p2';
        $style = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $works->getStyle($header)->applyFromArray($style);

        $c = 0;
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setWidth(40);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setWidth(60);
        $works->getColumnDimension($col[$c++])->setWidth(60);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setAutoSize(true);
        $works->getColumnDimension($col[$c++])->setWidth(60);

        $writer = \PHPExcel_IOFactory::createWriter($excOnsite, 'Excel2007');
        $writer->setIncludeCharts(true);

        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        $writer->save('php://output');

    }
}
