<?php
namespace App\Traits;
 
trait excelColumnTrait {

    public function getExcelColumn()
    {
        $col = [
            0 => 'a', 1 => 'b', 2 => 'c', 3 => 'd', 4 => 'e', 5 => 'f', 6 => 'g', 7 => 'h', 8 => 'i', 9 => 'j',
            10 => 'k', 11 => 'l', 12 => 'm', 13 => 'n', 14 => 'o', 15 => 'p', 16 => 'q', 17 => 'r', 18 => 's', 19 => 't',
            20 => 'u', 21 => 'v', 22 => 'w', 23 => 'x', 24 => 'y', 25 => 'z', 26 => 'aa', 27 => 'ab', 28 => 'ac', 29 => 'ad',
            30 => 'ae', 31 => 'af', 32 => 'ag', 33 => 'ah', 34 => 'ai', 35 => 'aj', 36 => 'ak', 37 => 'al', 38 => 'am', 39 => 'an',
            40 => 'ao', 41 => 'ap', 42 => 'aq', 43 => 'ar', 44 => 'as', 45 => 'at', 46 => 'au', 47 => 'av', 48 => 'aw', 49 => 'ax',
            50 => 'ay', 51 => 'az'
        ];

        return $col;
    }
    
}