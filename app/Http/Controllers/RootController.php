<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RootController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index(Request $request)
	{
		if($request->user()->id!=1) {
			return view('errors.404');
		}
		
		return view('root.index');
	}
}
