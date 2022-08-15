<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobStack extends Model
{
    use SoftDeletes;
	
	public function job()
	{
		return $this->belongsTo('App\Job');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	public function scopeTop($query, Job $job)
	{
		return $query->where('job_id', $job->id)
					 ->orderBy('stack_number', 'desc');
	}
}
