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

    /*
    fn queryData
    @param $department = department_id
    @param $sts = [0=> *time*<24hr, 1=> 24hr<*time*<48hr, 2=> 48hr<*time*<aaa
    @return $data
    */
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
        $nc = 19;

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
        $works->setCellValue($col[$c++] . $row, 'อุปกรณ์ที่เกี่ยวข้อง');
        $works->setCellValue($col[$c++] . $row, 'รุ่นอุปกรณ์');
        $works->setCellValue($col[$c++] . $row, 'หมายเลขอุปกรณ์');
        $works->setCellValue($col[$c++] . $row, 'Ticket Vender');
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
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->product)? "" : $job->scsjob->product);
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->model_part_number)? "" : $job->scsjob->model_part_number);
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->serial_number)? "" : $job->scsjob->serial_number);
            $works->setCellValue($col[$c++] . $row, empty($job->scsjob->malfunction)? "" : $job->scsjob->malfunction);
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

            $COLUMN_TEL = 5;
            $COLUMN_TICKET_VENDER = 11;
            
            $works->getStyle($col[$COLUMN_TEL].$row)->getNumberFormat()->setFormatCode('0000000000');
            $works->getStyle($effect_row)->getAlignment()->setWrapText(true);
            $works->getStyle($effect_row)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
            $works->getStyle($col[$COLUMN_TEL].$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $works->getStyle($col[$COLUMN_TICKET_VENDER].$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $works->getStyle($effect_row)->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        }
        $header = 'a1:t2';
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
