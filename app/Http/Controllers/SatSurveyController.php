<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\SatSurvey;
use App\Job;

class SatSurveyController extends Controller
{
    public function index(Request $request)
	{
        $this->middleware('auth');

        if (!$request->user()) {
            return redirect('/q');
        }

        $surveyList = SatSurvey::orderBy('created_at', 'desc')->paginate(100);

        return view('sat_survey.index', [
            'surveyList' => $surveyList
        ]);
	}

    public function create(Request $request)
	{
        $ticketNo = $request->get('ticket');
        return view('sat_survey.create', [
            'ticketNo' => $ticketNo
        ]);
	}

    public function store(Request $request)
	{
        $job = Job::where('ticket_no', $request->get('ticket_or_job'))->first()
            ?:Job::where('id', $request->get('ticket_or_job'))->first();
        
        if (!$job) {
            $request->flash();
            return redirect('/sat-survey/create')
                ->withErrors(['Ticket No / Job Number not found']);
        }

        $ipAddress = getenv('HTTP_CLIENT_IP')?:
            getenv('HTTP_X_FORWARDED_FOR')?:
            getenv('HTTP_X_FORWARDED')?:
            getenv('HTTP_FORWARDED_FOR')?:
            getenv('HTTP_FORWARDED')?:
            getenv('REMOTE_ADDR');

        $satSurvey = new SatSurvey();
        $satSurvey->visitor = $ipAddress;
        $satSurvey->job_id = $job->id;
        $satSurvey->ticket_no = $job->ticket_no;
        $satSurvey->created_user = $request->user()->team == 'CC' ? 'CC' : 'ANONYMOUS';
        $satSurvey->fill($request->all());
        $satSurvey->save();

        return redirect('/sat-survey/thank');
	}

    public function thank()
    {
        return view('sat_survey.thank');
    }

    public function jobIndex(Request $request)
	{
        $this->middleware('auth');
	}

    public function jobCreate(Request $request)
	{
        $this->middleware('auth');
	}

    public function jobStore(Request $request)
	{
        $this->middleware('auth');
	}
}
