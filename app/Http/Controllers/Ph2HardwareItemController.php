<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ph2HardwareItem;

use Excel;

class Ph2HardwareItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index() 
	{
		$items = Ph2HardwareItem::all();
		
		return view('hw_ph2.index', [
			'items' => $items,
		]);
	}
	
	public function import(Request $request)
	{
		return view('hw_ph2.import');
	}
	
	public function import_commit(Request $request) 
	{
		$errors = [];
		$filename = '';
		$results = [];
		
		if($request->file('file_import')) {
			
			if($request->file('file_import')->getClientMimeType()=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
			|| $request->file('file_import')->getClientMimeType()=="application/vnd.ms-excel")
			{
				$filename = $request->file('file_import')->getRealPath();
				
				Excel::load($filename, function($reader) use ($request) {
				
					// Getting all results
					$results = $reader->get();
					
					foreach($results as $sheet)
					{
						
						foreach($sheet as $row)
						{
							//dd($row);
							if(empty($row->serial_number)) {
								continue;
							}
							
							$hw = Ph2HardwareItem::where('serial_number', $row->serial_number)->first();
							
							if(empty($hw)) {
								$hw = new Ph2HardwareItem;
								$hw->create_user_id = $request->user()->id;
								$hw->serial_number = $row->serial_number;
							}
							
							$hw->product = $row->type;
							$hw->model_part_number = $row->brandmodel;
							$hw->install_location = $row->sitenamenew;
							//$hw->note  = $row->note ;
							
							$hw->save();
							
						}
					}

				});
				
			}
			else
			{
				$errors = array_add($errors, count($errors)+1, 'File must be .xls or .xlsx');
			}
			
		}
	}
}
