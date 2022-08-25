<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;
use App\User;
use Carbon\Carbon;

class Job extends Model
{
    use SoftDeletes;

    public function scsjob()
    {
        return $this->hasOne('App\ScsJob');
    }

    public function job_stacks()
    {
        return $this->hasMany('App\JobStack', 'job_id');
    }

    public function create_user()
    {
        return $this->belongsTo('App\User');
    }

    public function active_operator()
    {
        return $this->belongsTo('App\User');
    }

    public function last_operator()
    {
        return $this->belongsTo('App\User');
    }

    public function tier2_solve_user()
    {
        return $this->belongsTo('App\User', 'tier2_solve_user_id');
    }

    public function tier3_solve_user()
    {
        return $this->belongsTo('App\User', 'tier3_solve_user_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function system()
    {
        return $this->belongsTo('App\System');
    }

    public function primary_system()
    {
        return $this->belongsTo('App\System', 'primary_system_id');
    }

    public function secondary_system()
    {
        return $this->belongsTo('App\System', 'secondary_system_id');
    }

    public function call_category()
    {
        return $this->belongsTo('App\CallCategory', 'call_category_id');
    }

    public function sa_rw_primary_system()
    {
        return $this->belongsTo('App\System', 'sa_rw_primary_system_id');
    }

    public function sa_rw_secondary_system()
    {
        return $this->belongsTo('App\System', 'sa_rw_secondary_system_id');
    }

    public function sa_rw_call_category()
    {
        return $this->belongsTo('App\CallCategory', 'sa_rw_call_category_id');
    }

    public function active_operator_name()
    {
        if ($this->active_operator) {
            return $this->active_operator->name;
        } else {
            return '';
        }
    }

    public function active_operator_phone_number()
    {
        if ($this->active_operator) {
            return $this->active_operator->phone_number;
        } else {
            return '';
        }
    }

    public function last_operator_name()
    {
        if ($this->last_operator) {
            return $this->last_operator->name;
        } else {
            return '';
        }
    }

    public function last_operator_phone_number()
    {
        if ($this->last_operator) {
            return $this->last_operator->phone_number;
        } else {
            return '';
        }
    }

    public function sa_rw_name()
    {
        if ($this->sa_rw) {
            $user = User::find($this->sa_rw_id);
            if ($user) {
                return $user->name;
            }
        } else {
            return '';
        }
    }

    public function sa_rw_phone_number()
    {
        if ($this->sa_rw) {
            $user = User::find($this->sa_rw_id);
            if ($user) {
                return $user->phone_number;
            }
        } else {
            return '';
        }
    }

    public function progress()
    {
        if ($this->closed) {
            if ($this->scsjob) {
                $diff = $this->created_at->diffInMinutes(new Carbon($this->scsjob->action_dtm));
            } else {
                $diff = $this->created_at->diffInMinutes(new Carbon($this->closed_at));
            }
        } else {
            $diff = $this->created_at->diffInMinutes(Carbon::now());
        }

        $t = null;

        // 2 102 = 4*60 = 240
        // 5 105 = 48*60 = 2880
        // 1 101 3 103 4 104 13 106 14 107 = 24*60 = 1440
        if ($this->sa_rw_call_category_id == '2') {
            $t = 240;
        } elseif ($this->sa_rw_call_category_id == '5') {
            $t = 2880;
        } elseif ($this->sa_rw_call_category_id == '1' || $this->sa_rw_call_category_id == '3'
            || $this->sa_rw_call_category_id == '4' || $this->sa_rw_call_category_id == '13'
            || $this->sa_rw_call_category_id == '14')
        {
            $t = 1440;
        } elseif ($this->call_category_id == '2') {
            $t = 240;
        } elseif ($this->call_category_id == '5') {
            $t = 2880;
        } elseif ($this->call_category_id == '1' || $this->call_category_id == '3'
            || $this->call_category_id == '4' || $this->call_category_id == '13'
            || $this->call_category_id == '14')
        {
            $t = 1440;
        }

        $progress = [];
        $progress['p'] = ($diff / $t) * 100 > 100 ? 100 : round(($diff / $t) * 100);
        $progress['h'] = ($t - $diff) > 0 ? $this->convertToHoursMins($t - $diff) : 0;
        return $progress;
    }

    public function SLACount()
    {
        if ($this->closed) {
            if ($this->scsjob) {
                $diff = $this->created_at->diffInMinutes(new Carbon($this->scsjob->action_dtm));
            } else {
                $diff = $this->created_at->diffInMinutes(new Carbon($this->closed_at));
            }
        } else {
            $diff = $this->created_at->diffInMinutes(Carbon::now());
        }

        $t = null;

        // 2 102 = 4*60 = 240
        // 5 105 = 48*60 = 2880
        // 1 101 3 103 4 104 13 106 14 107 = 24*60 = 1440
        if ($this->sa_rw_call_category_id == '2') {
            $t = 240;
        } elseif ($this->sa_rw_call_category_id == '5') {
            $t = 2880;
        } elseif ($this->sa_rw_call_category_id == '1' || $this->sa_rw_call_category_id == '3'
            || $this->sa_rw_call_category_id == '4' || $this->sa_rw_call_category_id == '13'
            || $this->sa_rw_call_category_id == '14')
        {
            $t = 1440;
        } elseif ($this->call_category_id == '2') {
            $t = 240;
        } elseif ($this->call_category_id == '5') {
            $t = 2880;
        } elseif ($this->call_category_id == '1' || $this->call_category_id == '3'
            || $this->call_category_id == '4' || $this->call_category_id == '13'
            || $this->call_category_id == '14')
        {
            $t = 1440;
        }

        $progress = [];
        $progress['p'] = ($diff / $t) * 100 > 100 ? 100 : round(($diff / $t) * 100);
        $progress['h'] = ($t - $diff) > 0 ? $this->convertToHoursMins($t - $diff) : 0;
        return $progress;
    }

    public function isSla()
    {
        if ($this->sa_rw_call_category_id) {
            if ($this->sa_rw_call_category_id == '1' || $this->sa_rw_call_category_id == '2'
                || $this->sa_rw_call_category_id == '3' || $this->sa_rw_call_category_id == '4'
                || $this->sa_rw_call_category_id == '5' || $this->sa_rw_call_category_id == '13'
                || $this->sa_rw_call_category_id == '14'
            ) {
                return true;
            } else {
                return false;
            }
        } elseif ($this->call_category_id) {
            if ($this->call_category_id == '1' || $this->call_category_id == '2'
                || $this->call_category_id == '3' || $this->call_category_id == '4'
                || $this->call_category_id == '5' || $this->call_category_id == '13'
                || $this->call_category_id == '14')
            {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function convertToHoursMins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public function survey()
    {
        return $this->hasMany('App\SatSurvey', 'job_id');
    }

    public function getSurveyIcon() 
    {
        if ($this->survey()->count()) {
            $numStar = $this->survey()->latest()->first()->q1;
            $star = '';
            for ($i=1; $i<=$numStar; $i++) {
                $star .= '<i class="fa fa-star star" aria-hidden="true"></i>';
            }
            return $star;
        }
    }

//    echo convertToHoursMins(250, '%02d hours %02d minutes');

    /*public function datum($ymd)
    {
        dd($this);
        return  $this->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $ymd)->first()->total;
    }*/
}
