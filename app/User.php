<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'team', 'code_name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	
	public function jobs()
	{
		return $this->hasMany('App\Job','create_user_id');
	}
	
	public function job_stacks()
	{
		return $this->hasMany('App\JobStack', 'user_id');
	}
}
