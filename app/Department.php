<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;

class Department extends Model
{
    public function jobs()
	{
		return $this->hasMany('App\Job', 'department_id');
	}

	public function jobs_day ($start, $end) {
		$start = strtotime($start);
		$end = strtotime($end);
		$data = $this->jobs()
					->whereBetween('created_at', [date('Y-m-d 00:00:00', $start), date('Y-m-d 23:59:59', $end)]);
		return $data;
	}
}
