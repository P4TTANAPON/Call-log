<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Ph1HardwareItem;
use App\HardwareItem;

class HwController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function search(Request $request) 
	{
		header('Content-Type: application/json');
		
		$hw = null;
		
		// if($request->phase == '1') {
		// 	$hw = HardwareItem::where('phase', $request->phase)-> where('serial_number', $request->get('sn'))->first();
		// } elseif($request->phase == '2') {
		// 	$hw = HardwareItem::where('serial_number', $request->get('sn'))->first();
		// } elseif($request->phase == '4') {
		// 	$hw = HardwareItem::where('serial_number', $request->get('sn'))->first();
		// }
		$hw = HardwareItem::where('phase', $request->phase)->  where('serial_number', $request->get('serial_number'))->first(); //where('departments_id', $request->department)->
		
		if(empty($hw)) {
			return '{"result": false}';
		} else {
			return '{"result": true, "product": "'.$hw->product.'", "model_part_number": "'.$hw->model_part_number.'"}';
		}
 	}

	 public function getAll(Request $request) 
	 {
		//$items = 	HardwareItem::where('phase', '4')->get(['id','serial_number',' selected sel']);


		//header('Content-Type: application/json');
		
		$hw = null;
		$hw = HardwareItem::where('phase', '4')->get(['serial_number']);
		
		if(empty($hw)) {
			return '[]';
		} else {
			$html = '';
				foreach($hw as $item) 
				{	
					$html .=  $item->serial_number . ',';
				}
			return rtrim($html, ",");
			
		}
	
	  }

	//  public function getAll(Request $request) 
	//  {
	// 	//$items = 	HardwareItem::where('phase', '4')->get(['id','serial_number',' selected sel']);


	// 	$items = HardwareItem::select('id','serial_number',
	// 		DB::raw('(CASE WHEN hardware_items.id = ' . $request->get('hw_id') . ' 
	// 			THEN "selected" 
	// 			ELSE "" END) AS 
	// 			sel'))
    //         ->where('phase', '4')
    //         ->get();

	// 	$html = '<option value="">Require</option>';
	// 	//' . ($request->get('hw_id') == $item->id ?  "selected" :  "")  . '
	// 	foreach($items as $item) 
	// 	{	
			
	// 		$html .= '<option value="' . $item->id . '"  ' . $item->sel . ' > ' . $item->serial_number . '</option>';
	// 	}
		
	// 	return $html;
	//   }
}
