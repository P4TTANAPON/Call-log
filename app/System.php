<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    public function jobs()
	{
		return $this->hasMany('App\Job', 'system_id');
	}
}
