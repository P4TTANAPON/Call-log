<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\HardwareItem;
use Excel;
use App\Department;
use App\CallCategory;
use App\ScsJob;

class HardwareItemController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index(Request $request) 
	{
		$items = null;
		if ($request->get('department') || $request->get('model_part_number') || $request->get('serial_number') || $request->get('hw_status')){
			$items = $this->queryData($request);
			//$items = $items -> orderBy('product', 'asc');
			
		}else{
			$items = HardwareItem::where('model_part_number','')->get();
			//return redirect('/hw')->with('success', 'กรุณาระบุคำค้น');
		}
		//$items = $items->orderBy('model_part_number', 'asc');

		$product = 	HardwareItem::distinct()->orderBy('model_part_number','asc')->get(['model_part_number']);
		

		return view('hw.index', [
			'items' => $items,
			'departments' => Department::all(),
            'products' => $product,
		]);		
	}
	
	private function queryData($request)
    {       

		if ($request->get('hw_status') == "2") {
			if ($request->get('serial_number')) {
				$items = HardwareItem::join('scs_jobs', 'hardware_items.id', '=', 'scs_jobs.hw_id')
				->join('jobs', 'jobs.id', '=', 'scs_jobs.job_id')
				->where('scs_jobs.action_dtm', null)
				->where('jobs.deleted_at', null)
				->where('hardware_items.serial_number','LIKE','%'. $request->get('serial_number').'%')
				->distinct()->get(['hardware_items.*']);
			}else{
				$items = HardwareItem::join('scs_jobs', 'hardware_items.id', '=', 'scs_jobs.hw_id')
				->join('jobs', 'jobs.id', '=', 'scs_jobs.job_id')
				->where('scs_jobs.action_dtm', null)
				->where('jobs.deleted_at', null)
				->distinct()->get(['hardware_items.*']);
			}
			
		}else if ($request->get('hw_status') == "1"){
			if ($request->get('serial_number')) {
				$items = HardwareItem::join('scs_jobs', 'hardware_items.id', '=', 'scs_jobs.hw_id')
				->join('jobs', 'jobs.id', '=', 'scs_jobs.job_id')
				->where('scs_jobs.action_dtm', '<>', '')
				->where('jobs.deleted_at', null)
				->where('hardware_items.serial_number','LIKE','%'. $request->get('serial_number').'%')
				->distinct()->get(['hardware_items.*']);
			}else{
				$items = HardwareItem::join('scs_jobs', 'hardware_items.id', '=', 'scs_jobs.hw_id')
				->join('jobs', 'jobs.id', '=', 'scs_jobs.job_id')
				->where('scs_jobs.action_dtm', '<>', '')
				->where('jobs.deleted_at', null)
				->distinct()->get(['hardware_items.*']);
			}
			
		}else{
			if ($request->get('serial_number')) {
				$items = HardwareItem::where('serial_number','LIKE','%'. $request->get('serial_number').'%') -> orderBy('product', 'asc') -> orderBy('model_part_number', 'asc') ->get();
			}else{
				$items = HardwareItem::orderBy('product', 'asc') 
					-> orderBy('model_part_number', 'asc') 
					-> orderBy('serial_number', 'asc') 
					-> get();
			}
			
		}

		if ($request->get('department')) {
            $items = $items->where('departments', $request->get('department'));
        }

		if ($request->get('model_part_number')) {
            $items = $items->where('model_part_number', $request->get('model_part_number'));
        }

        return $items;
    }

	public function import(Request $request)
	{
		return view('hw.import');
	}
	
	public function import_commit(Request $request) 
	{
		$errors = [];
		$filename = '';
		$results = [];
		
		//dd($request->file('file_import')->getClientMimeType());
		
		if($request->file('file_import')) {
			// print $request->file('file_import')->getRealPath();
			// print $request->file('file_import')->getClientMimeType();
			// print $request->file('file_import')->getClientOriginalName();
			
			if($request->file('file_import')->getClientMimeType()=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
			|| $request->file('file_import')->getClientMimeType()=="application/vnd.ms-excel")
			{
				//print $filename;
				$filename = $request->file('file_import')->getRealPath();
				//echo $filename;
				//dd($filename);
				Excel::load($filename, function($reader) use ($request) {

					//$sheets->each(function($sheet) {
					//	dd($sheet);
					//});
				
					// Getting all results
					$results = $reader->get();
					//print $results;
					$index = 0;
					
					foreach($results as $sheet)
					{
						// get sheet title
						//$sheetTitle = $sheet->getTitle();
						//print($sheetTitle);
						// if ($index != 0){
						// 	$index += 1;
						// 	continue;
						// }
						$lastProductName = '';
						$lastModelName = '';
						$lastLandOfficeName = '';
					
						foreach($sheet as $row)
						{
							if(empty($row->serial_number)  ) { // || empty($row->model_part_number) || empty($row->inventory_no)
								continue;
							}
							
							//print $row;
							//dd($row);
							$hw = HardwareItem::where('serial_number', $row->serial_number)->first();
							
							if(empty($hw)) {
								$hw = new HardwareItem;
								$hw->create_user_id = $request->user()->id;
								$hw->serial_number = $row->serial_number;
							}else{
								$hw = new HardwareItem;
								$hw->create_user_id = $request->user()->id;
								$hw->serial_number = $row->serial_number;
								$hw->note  = 'duplicate serial' ;
							}
							
							// if($lastProductName == ''){
							// 	$lastProductName = $row->product;
							// }else 
							if ($lastProductName != $row->product){
								$lastProductName = $row->product;
							}

							if($lastModelName == ''){
								$lastModelName = $row->model_part_number;
							}else if ($lastModelName != $row->model_part_number){
								$lastModelName = $row->model_part_number;
							}

							if($lastLandOfficeName == ''){
								$lastLandOfficeName = $row->departments;
							}else if ($row->departments != '' and $lastLandOfficeName != $row->departments){
								$lastLandOfficeName =$row->departments;
							}

							$hw->product = $lastProductName;
							$hw->model_part_number = $lastModelName;
							$hw->inventory_no = $row->inventory_no;
							$hw->phase = '4';
							$hw->departments = $lastLandOfficeName;
							
							
							$hw->save();
							
						}
						// $index += 1;
					}

					//dd($results);
					
					// ->all() is a wrapper for ->get() and will work the same
					//$results = $reader->all();

				});
				
			}
			else
			{
				$errors = array_add($errors, count($errors)+1, 'File must be .xls or .xlsx');
			}
			
			//$messages = array_add($messages, count($messages)+1, 'File upload success');
		}
	}

	public function create(Request $request)
	{
		
		$product = 	HardwareItem::distinct()->orderBy('product','asc')->get(['product']);
		$model_part_number = 	HardwareItem::distinct()->orderBy('model_part_number','asc')->get(['model_part_number']);
		$department = 	HardwareItem::distinct()->orderBy('departments','asc')->get(['departments']);
		
		return view('hw.create', [
			//'items' => $items,
			'departments' => $department,
            'products' => $product,
			'model_part_numbers' => $model_part_number,
		]);		
	
	}

	public function store(Request $request) 
	{
		if ($request->id != ""){
			//update
			$hw = HardwareItem::where('id', $request->get('id'))->first();	
			if(!empty($hw)) {
				$hw->create_user_id = $request->user()->id;
				$hw->departments = $request->department;
				$hw->serial_number = $request->serial_number;
				$hw->product = $request->product;
				$hw->model_part_number = $request->model_part_number;
				$hw->inventory_no = $request->inventory_no;
				$hw->phase = '4';
				if(!empty(HardwareItem::where('serial_number','=', $request->serial_number)-> where('id', '<>', $request->get('id')) ->first())){
					$hw->note  = 'duplicate serial' ;
				}else{
					$hw->note  = '' ;
				}
				$hw->save();
				return redirect('/hw?serial_number=' . $request->serial_number)->with('success', 'แก้ไขรายการอุปกรณ์เรียบร้อย');
			}else{
				return redirect('/hw/edit?id=' . $request->id);
			}		
		}else{
			//insert
			$hw = HardwareItem::where('serial_number', $request->serial_number) ->first();	
			if(empty($hw)) {
				$hw = new HardwareItem;
				$hw->create_user_id = $request->user()->id;
				$hw->departments = $request->department;
				$hw->serial_number = $request->serial_number;
				$hw->product = $request->product;
				$hw->model_part_number = $request->model_part_number;
				$hw->inventory_no = $request->inventory_no;
				$hw->phase = '4';
				$hw->save();
				return redirect('/hw/create')->with('success', 'เพิ่มรายการอุปกรณ์เรียบร้อย');
			}else{
				return redirect('/hw/create?department=' . $request->department
					. '&serial_number=' . $request->get('serial_number') 
					. '&product=' . $request->get('product') 
					. '&model_part_number=' . $request->get('model_part_number') 
					. '&inventory_no=' . $request->get('inventory_no'))->with('success', 'serial number มีในระบบแล้ว');
			}		
		}
		
	}

	public function edit(Request $request)
    {
		$product = 	HardwareItem::distinct()->orderBy('product','asc')->get(['product']);
		$model_part_number = HardwareItem::distinct()->orderBy('model_part_number','asc')->get(['model_part_number']);
		$department = 	HardwareItem::distinct()->orderBy('departments','asc')->get(['departments']);
		
		if ($request->get('id') != null){
			//$items = HardwareItem::where('id','=', $request->get('id')) ->get();
			$items = HardwareItem::where('id', $request->get('id'))->first();	
			return view('hw.edit.index', [
				'items' => $items,
				'departments' => $department,
				'products' => $product,
				'model_part_numbers' => $model_part_number,
			]);		
		}else{
			return redirect('/hw');
		}
    }

	public function delete(Request $request)
    {
		if ($request->get('id') != null){
			$items = HardwareItem::where('id', $request->get('id'))->first();	
			return view('hw.delete', [
				'items' => $items,
			]);		
		}
    }

	public function destroy(Request $request, HardwareItem $items)
    {
        //if (!$this->deleteAuth($request, $items)) abort(401);
		if ($request->get('id') != null){
			$items = HardwareItem::where('id', $request->get('id'))->first();	
			$items->delete();
			return redirect('/hw')->with('success', 'ลบข้อมูลเรียบร้อย.');
		}else{
			return redirect('/hw')->with('success', 'ไม่พบรายการที่ต้องการลบข้อมูล.');
		}
    }

	public function show(Request $request)
    {		
		if ($request->get('id') != null){
			$items = HardwareItem::where('id', $request->get('id'))->first();	
			//$Hisitems = ScsJob::where('hw_id', $request->get('id'))->get();	

			$Hisitems = ScsJob::join('jobs', 'jobs.id', '=', 'scs_jobs.job_id')
				->where('jobs.deleted_at', null)
				->where('scs_jobs.hw_id','=',''. $request->get('id') .'')
				->get(['scs_jobs.*']);

			return view('hw.show.index', [
				'items' => $items,
				'hisItems' => $Hisitems,
			]);		
		}else{
			return redirect('/hw');
		}
    }
}
