<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public static function defaultTypes()
    {
        return [
            ['name'=>'Menerima Cahaya Mata','slug'=>'get_baby','limit'=>'3'],
            ['name'=>'Berkahwin','slug'=>'get_married','limit'=>null],
            ['name'=>'Ditahan Wad','slug'=>'warded','limit'=>'1'],
            ['name'=>'Kematian Keluarga','slug'=>'family_death','limit'=>'1'],
            ['name'=>'Haji dan Umrah','slug'=>'hajj_and_umra','limit'=>'1'],
        ];
    }
}
