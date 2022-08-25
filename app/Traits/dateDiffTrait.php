<?php
namespace App\Traits;
 
trait dateDiffTrait {

    public static function datediff($date1, $date2)
    {
        $diff = abs(strtotime($date1) - strtotime($date2));

        return sprintf(
            "%d Days, %s:%s:%s",
            intval($diff / 86400),
            str_pad(intval(($diff % 86400) / 3600), 2, '0', STR_PAD_LEFT),
            str_pad(intval(($diff / 60) % 60), 2, '0', STR_PAD_LEFT),
            str_pad(intval($diff % 60), 2, '0', STR_PAD_LEFT)
        );
    }

    public static function datediffHr($date1, $date2){
        $diff = abs(strtotime($date1) - strtotime($date2));

        return sprintf(
            "%s Hour(s) %s Minute(s)",
            str_pad(intval($diff/3600), 2, '0', STR_PAD_LEFT),
            str_pad(intval(($diff/60)%60), 2, '0', STR_PAD_LEFT)
        );
    }
}