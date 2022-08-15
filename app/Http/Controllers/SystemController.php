<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\System;

class SystemController extends Controller
{
    public function getdropdown(Request $request)
	{
		$systems = System::where('phase', $request->get('phase'))->orderBy('flag')->get();
		
		$html = '<option value="">All System</option>';
		
		foreach($systems as $system) 
		{
			$html .= '<option value="' . $system->id . '" ' . ($request->get('system') == $system->id ? 'selected' : '') . '>' . $system->flag . '</option>';
		}
		
		return $html;
	}
}
