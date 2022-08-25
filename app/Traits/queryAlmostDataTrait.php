<?php
namespace App\Traits;

use App\Job;
 
trait queryAlmostDataTrait {
 
    /*
    fn queryDataOver
    @param $department = department_id
    @param $project = [1=>DOL1, 2=>DOL2, 4=>DOL4]
    @param $sts = [0=>12-24hr, 1=>36-48hr]
    @return $data
    */
    public function queryDataAlmost($department, $project, $sts){
        $data;
        if($sts == 0){
            $data = Job::where(function($query) use ($department,$project){
                $query->where(function($query) use ($department,$project){
                    $query->where('closed','=','0')
                        ->whereNull('scs_solve_user_dtm')
                        ->where('call_category_id','=','5')
                        ->whereRaw('NOW() < Date_Add(created_at, INTERVAL 24 HOUR)')
                        ->whereRaw('NOW() > Date_Add(created_at, INTERVAL 12 HOUR)');

                    if($department!="") $query->where('department_id','=',$department);
                    if($project!="") $query->where('phase','=',$project);
                });
            })
            ->orderBy('created_at','desc');
        } else if ($sts == 1){
            $data = Job::where(function($query) use ($department,$project){
                $query->where(function($query) use ($department,$project){
                        $query->where('closed','=','0')
                            ->whereNotNull('scs_solve_user_dtm')
                            ->whereRaw('NOW() > Date_Add(created_at, INTERVAL 36 HOUR)')
                            ->whereRaw('NOW() < Date_Add(created_at, INTERVAL 48 HOUR)')
                            ->where('call_category_id','=','5');
                        
                        if($department!="") $query->where('department_id','=',$department);
                        if($project!="") $query->where('phase','=',$project);
                    });
            })
            ->orderBy('created_at','desc');
        }

        return $data;
    }
 
}
