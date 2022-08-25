<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    public function getdropdown(Request $request)
	{
		if ($request->get('team')){
			if ($request->get('team') == 'cc-sp-sa'){
				$users = User::where('deleted_at', '=', null) 
				-> orWhere('team', '=',  'CC') 
				-> orWhere('team', '=',  'SP') 
				-> orWhere('team', '=',  'SA') 
				-> get();
			}else{
				$users = User::where('team', '=', $request->get('team')) -> where('deleted_at', '=', null)->get();
			}
		}else{
			$users = User::where('deleted_at', '=', null)->get();
		}
		
		
		$html = '<option value="">All User</option>';
		
		foreach($users as $user) 
		{
			$html .= '<option value="' . $user->id . '" ' . ($request->get('team') == $user->id ? 'selected' : '') . '>' . $user->name . '</option>';
		}
		
		return $html;
	}
}
