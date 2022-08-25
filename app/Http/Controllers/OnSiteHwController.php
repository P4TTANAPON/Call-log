<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\Environment;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;

use App\Job;
use App\Department;

use Excel;
use DB;

class OnSiteHwController extends Controller
{

    public function index(Request $request){
        if(isset($request->fromDate) && isset($request->toDate)){
			$start = $request->fromDate;
			$end = $request->toDate;
		} else {
			$start = date('Y-m-d');
			$end = date('Y-m-d');
		}

        $hw = DB::table('hardware_items')
                    ->selectRaw('hardware_items.product, count(scs_jobs.id) as jobs')
                    ->join('scs_jobs','scs_jobs.hw_id','=','hardware_items.id')
                    ->join('jobs','jobs.id','=','scs_jobs.job_id')
                    ->whereNull('jobs.deleted_at')
                    ->whereNull('scs_jobs.deleted_at')
                    ->whereBetween('jobs.created_at', [date('Y-m-d 00:00:00', strtotime($start)), date('Y-m-d 23:59:59', strtotime($end))])
                    ->groupBy('hardware_items.product');
        if(isset($request->department) && $request->department != ""){
            $hw = $hw->where('jobs.department_id','=',$request->department);
            $depName = Department::find($request->department)->name;
        }else{
            $depName = "";
        }
        $phase = array(1,2,4);
        if(in_array($request->phase,$phase)){
            $hw = $hw->where('jobs.phase','=',$request->phase);
        }

        $hw = $hw->orderBy(DB::Raw('COUNT(scs_jobs.id)'),'desc');

        if(isset($request->name)){
            $name = $request->name;
        } elseif ($hw->count()){
            $name = $hw->first()->product;
        }
        if($hw->count()){
            $hwDet = $this->getDetailHw($request,$name,$start,$end);
            $hwDet = $hwDet->paginate(25, ['*'], 'hwDet');
        } else {
            $hwDet = [];
            $name = "";
        }

        $hw = $hw->paginate(25, ['*'], 'hw');
        
		$lava = new Lavacharts;
        $group_hw = $lava->DataTable();
        $group_hw->addStringColumn('Problem')->addNumberColumn('Jobs');

        foreach ($hw as $item) {
            $group_hw->addRow([$item->product, $item->jobs]);
        }

        $lava->PieChart('group_hw', $group_hw, [
            'is3D'   => true,
            'legend' => [
                'position' => 'left',
            ],
            'chartArea' => [
                'top' => 5,
                'left' => 0,
                'width' => '100%',
                'height' => 320
            ]
        ]);
        
        return view('onsite_hw.index')
            ->with('departments',Department::all())
            ->with('start',$start)
            ->with('end',$end)
            ->with('hw',$hw)
            ->with('depName',$depName)
            ->with('lava',$lava)
            ->with('hwDet',$hwDet)
            ->with('name',$name);
    }

    public function getDetailHw(Request $request,$name,$start,$end){
        $hwDet = DB::table('hardware_items')
                    ->selectRaw('jobs.id, jobs.ticket_no, hardware_items.product, hardware_items.model_part_number, hardware_items.serial_number, hardware_items.departments, hardware_items.phase')
                    ->join('scs_jobs','scs_jobs.hw_id','=','hardware_items.id')
                    ->join('jobs','jobs.id','=','scs_jobs.job_id')
                    ->whereNull('jobs.deleted_at')
                    ->whereNull('scs_jobs.deleted_at')
                    ->where('hardware_items.product','like',$name)
                    ->whereBetween('jobs.created_at', [date('Y-m-d 00:00:00', strtotime($start)), date('Y-m-d 23:59:59', strtotime($end))]);
        if(isset($request->department) && $request->department != ""){
            $hwDet = $hwDet->where('jobs.department_id','=',$request->department);
        }
        $phase = array(1,2,4);
        if(in_array($request->phase,$phase)){
            $hwDet = $hwDet->where('jobs.phase','=',$request->phase);
        }

        return $hwDet;
    }
}
