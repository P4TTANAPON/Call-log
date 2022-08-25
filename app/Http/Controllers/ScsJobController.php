<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Job;
use App\ScsJob;
use App\Ph1HardwareItem;
use App\Ph2HardwareItem;
use App\User;

use Mail;
use Excel;

class ScsJobController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index(Request $request)
    {
		$scs_jobs = ScsJob::all();
		
		return view('scs_job.index', [
			'scs_jobs' => $scs_jobs,
		]);
	}
	
    public function create(Request $request, $id)
    {
		if($request->user()->team != 'CC') {
			return view('errors.404');
		}
		
		$request->flash();
		
		$hw = false;
		$search = false;
		
		if($request->get('ph') and $request->get('search_serial_number')) 
		{
			if($request->get('ph') == '1') {
				$hw = Ph1HardwareItem::where('serial_number', $request->get('search_serial_number'))->first();
			} else if($request->get('ph') == '2') {
				$hw = Ph2HardwareItem::where('serial_number', $request->get('search_serial_number'))->first();
			}
			
			$search = true;
		}
		
		$job = Job::findOrFail($id);
		
        return view('scs_job.create', [
			'job' => $job,
			'scsJob' => new ScsJob,
			'hw' => $hw,
			'search' => $search,
		]);
    }
	
	public function store(Request $request, $id)
    {
		$job = Job::findOrFail($id);
		
		$scs = ScsJob::where('job_id', $id)->count();
		
		if($scs) {
			return redirect('/scs');
		}
		
		$scs = new ScsJob;
		$scs->create_user_id = $request->user()->id;
		$scs->job_id = $id;
		$scs->serial_number = $request->get('serial_number');
		$scs->product = $request->get('product');
		$scs->model_part_number = $request->get('model_part_number');
		$scs->malfunction = $request->get('malfunction');
		$scs->cause = $request->get('cause');
		$scs->action = $request->get('action');
		$scs->remark = $request->get('remark');
		$scs->save();
		
		$job->last_operator_id = $job->active_operator_id;
		$job->last_operator_team = $job->active_operator_team;
		
		$scs_user = User::where('team', 'SCS')->first();
		
		if($scs_user) {
			$job->active_operator_id = $scs_user->id;
		} else {
			$job->active_operator_id = $request->user()->id;
		}
		
		$job->active_operator_team = 'SCS';
		$job->save();
		
		// $filename = 'แบบฟอร์มกรอกข้อมูลเปิด Job ให้ SCS DOL ' . date('Y-m-d') . ' TicketNo ' . $job->ticket_no; 
		$filename = date('Y-m-d') . '_' . $job->ticket_no . '_' . $job->department->name;
		
		Excel::create($filename, function($excel) use ($job, $scs) {

			$excel->sheet('Sheet1', function($sheet) use ($job, $scs) {

				$sheet->loadView('scs_job.excel', [
					'job' => $job,
					'scs' => $scs,
				]);

			});

		})->store('xlsx', storage_path('excel/exports'));
		
		Mail::send('scs_job.mail', [], function ($m) use ($request, $filename, $job) {
            $m->to(config('mail.scs.address'), config('mail.scs.name'))->subject($filename);
			//$m->cc($request->user()->email, $request->user()->name);
			$m->cc('suntachotpop@gmail.com', 'suntachotpop@gmail.com');
			$m->cc('chatchai.k@samtel.samartcorp.com', 'chatchai.k@samtel.samartcorp.com');
			$m->cc('Helpdesk.dol57@yahoo.co.th', 'Helpdesk.dol57@yahoo.co.th');
			$m->attach(storage_path('excel/exports') . '/' . $filename . '.xlsx');
        });
		
		//dd($job);
		
		return redirect('/scs');
    }
}
