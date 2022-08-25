<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Job;

class ClosedController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$jobs = Job::where('closed', '1')->orderBy('created_at', 'desc')->get();
		
        return view('closed.index', [
			'jobs' => $jobs
		]);
    }
}
