<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ph1HardwareItem;

use Excel;

class Ph1HardwareItemController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index() 
	{
		$items = Ph1HardwareItem::all();
		
		return view('hw_ph1.index', [
			'items' => $items,
		]);
	}
	
	public function import(Request $request)
	{
		return view('hw_ph1.import');
	}
	
	public function import_commit(Request $request) 
	{
		$errors = [];
		$filename = '';
		$results = [];
		
		//dd($request->file('file_import')->getClientMimeType());
		
		if($request->file('file_import')) {
			//print $request->file('file_upload')->getRealPath();
			//print $request->file('file_upload')->getClientMimeType();
			//print $request->file('file_upload')->getClientOriginalName();
			
			if($request->file('file_import')->getClientMimeType()=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
			|| $request->file('file_import')->getClientMimeType()=="application/vnd.ms-excel")
			{
				$filename = $request->file('file_import')->getRealPath();
				//dd($filename);
				Excel::load($filename, function($reader) use ($request) {

					//$sheets->each(function($sheet) {
					//	dd($sheet);
					//});
				
					// Getting all results
					$results = $reader->get();
					
					foreach($results as $sheet)
					{
						// get sheet title
						//$sheetTitle = $sheet->getTitle();
						//print($sheetTitle);
						
						foreach($sheet as $row)
						{
							if(empty($row->serial_number)) {
								continue;
							}
							
							//dd($row);
							$hw = Ph1HardwareItem::where('serial_number', $row->serial_number)->first();
							
							if(empty($hw)) {
								$hw = new Ph1HardwareItem;
								$hw->create_user_id = $request->user()->id;
								$hw->serial_number = $row->serial_number;
							}
							
							$hw->product = $row->product;
							$hw->model_part_number = $row->model_part_number;
							$hw->install_location = $row->install_location;
							$hw->note  = $row->note ;
							
							$hw->save();
							
						}
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
}
