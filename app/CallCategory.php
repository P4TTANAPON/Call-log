<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallCategory extends Model
{
    public function jobs()
	{ 
		return $this->hasMany('App\Job', 'call_category_id');
	}
}
