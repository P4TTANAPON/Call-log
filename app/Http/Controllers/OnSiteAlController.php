<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\Environment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Job;
use App\Department;
use Carbon\Carbon;
use App\Traits\queryAlmostDataTrait;
use App\Traits\dateDiffTrait;

use Excel;

class OnSiteAlController extends Controller
{
    use queryAlmostDataTrait;
    use dateDiffTrait;

    public function index(Request $request){
        $department = !empty($request->department)? $request->department : "";
        $project = !empty($request->project)? $request->project : "";

        $almostIn = $this->queryDataAlmost($department, $project, 0);
        $almostEnd = $this->queryDataAlmost($department, $project, 1);
                
        $almostIn = $almostIn->paginate(10, ['*'], 'almostIn');
        $almostEnd = $almostEnd->paginate(10, ['*'], 'almostEnd');

        // foreach($al)
        
        return view('onsite_al.index')
                ->with('almostIn',$almostIn)
                ->with('almostEnd',$almostEnd)
                ->with('departments',Department::all());
    }
}
