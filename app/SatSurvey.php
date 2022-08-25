<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SatSurvey extends Model
{
    protected $table = "sat_survey";

    protected $fillable = [
        'q1','q2','q3','q4'
    ];

    public function getQ1TextAttribute()
    {
        if ($this->q1 == '1') {
            return 'ปรับปรุง';
        } else if ($this->q1 == '2') {
            return 'พอใช้';
        } else if ($this->q1 == '3') {
            return 'ดี';
        } else if ($this->q1 == '4') {
            return 'ดีมาก';
        } else if ($this->q1 == '5') {
            return 'ดีเยี่ยม';
        }
    }

    public function getSurveyIcon()
    {
        $star = '';
        for ($i=1; $i<=$this->q1; $i++) {
            $star .= '<i class="fa fa-star star" aria-hidden="true"></i>';
        }
        return $star;
    }
}
