<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScsJob extends Model
{
	use SoftDeletes;
	
    public function job()
	{
		return $this->belongsTo('App\Job');
	}
}
