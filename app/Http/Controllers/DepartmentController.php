<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Department;
use App\HardwareItem;
use App\Job;
use Khill\Lavacharts\Lavacharts;

class DepartmentController extends Controller
{
	public function index(Request $request) {
		if(isset($request->fromDate) && isset($request->toDate)){
			$start = $request->fromDate;
			$end = $request->toDate;
		} else {
			$start = date('Y-m-d');
			$end = date('Y-m-d');
		}
		// $departments = Department::all();
		$temp = DB::table('departments')
			->selectRaw('departments.*, COUNT(jobs.id) as works')
			->join('jobs','departments.id','=','jobs.department_id')
			->whereBetween('jobs.created_at', [date('Y-m-d 00:00:00', strtotime($start)), date('Y-m-d 23:59:59', strtotime($end))])
			->groupBy('departments.id')
			->orderBy('works', 'desc');

		$top5 = $temp->take(5)->get();
		$data = $temp->paginate(25);
		
		$lava = new Lavacharts;
		$chartData = $lava -> DataTable();
		$chartData->addStringColumn('Department')
			->addNumberColumn('Count');
		$n=0;
		
		if(!(empty($temp))){
			foreach($top5 as $d){
				$chartData->addRow([$d->name,$d->works]);
			}
		}
		$lava->ColumnChart('chartData', $chartData, [
			'title' => 'Department Chart',
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

		return view('department.index')
				->with('departments',$data)
				->with('start',$start)
				->with('end',$end)
				->with('lava', $lava);
	}

    public function getdropdown(Request $request)
	{
		$departments = Department::where('phase', $request->get('phase'))->get();
		
		$html = '<option value="">All Department</option>';
		
		foreach($departments as $department) 
		{
			$html .= '<option value="' . $department->id . '" ' . ($request->get('department') == $department->id ? 'selected' : '') . '>[DOL' . $department->phase . '] ' . $department->name . '</option>';
		}
		
		return $html;
	}

	public function getHWdropdown(Request $request)
	{
		$departments = 	HardwareItem::distinct()->where('phase', $request->get('phase'))->orderBy('departments','asc')->get(['departments']);
		$html = '<option value="">All Department</option>';
		
		foreach($departments as $department) 
		{
			$html .= '<option value="' . $department->departments . '" ' . ($request->get('department') == $department->departments ? 'selected' : '') . '>[DOL' . $request->get('phase') . '] ' . $department->departments . '</option>';
		}
		
		return $html;
	}

	public function getHWDepartment()
	{
		$departments = 	HardwareItem::distinct()->where('phase', '4')->orderBy('departments','asc')->get(['departments']);
		$html = '<option value="">All Department</option>';
		
		foreach($departments as $department) 
		{
			$html .= '<option value="' . $department->departments . '" > ' . $department->departments . '</option>';
		}
		
		return $html;
	}
}
