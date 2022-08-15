<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HardwareItem extends Model
{
	// public function department()
    // {
    //     return $this->hasOne('App\Department','id','departments_id');
    // }

    
    public function scsjobs()
    {
        return $this->hasMany('App\Scsjob', 'hw_id', 'id');
    }

    public function hw_status()
    {
        if ($this->scsjobs()->count() > 0) {
            $star = 'ปกติ';
            $items = Job::join('scs_jobs', 'jobs.id', '=', 'scs_jobs.job_id')
            ->where('scs_jobs.serial_number', $this->serial_number)
            ->where('jobs.deleted_at', null)
            ->get();
            foreach ($this->scsjobs() ->get() as $scsjob) {
                if($scsjob -> action_dtm == null && $scsjob -> delete_at == null){
                    $star = 'อยู่ระหว่างซ่อม';
                    break;
                }
            }
            return $star;
        }else{
            return 'ปกติ';
        }
    }

    public function job_count()
    {
        if ($this->scsjobs()->count() > 0) {
            $items = Job::join('scs_jobs', 'jobs.id', '=', 'scs_jobs.job_id')
            ->where('scs_jobs.serial_number', $this->serial_number)
            ->where('jobs.deleted_at', null)
            ->get();
    
            return $items->count();
        }else{
            return 0;
        }
    }
}
