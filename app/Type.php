<?php

namespace App;

use App\Application;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    // protected $casts = [
    //     'created_at' => 'datetime:d-m-Y g:i A',
    // ];

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'],'UTC')->setTimezone('Asia/Kuala_Lumpur')->format('d-m-Y g:i A');
    }

    protected $guarded = ['id'];

    public static function defaultTypes()
    {
        return [
            ['name'=>'Menerima Cahaya Mata','slug'=>'get_baby','limit'=>'3'],
            ['name'=>'Berkahwin','slug'=>'get_married','limit'=>'1'],
            ['name'=>'Ditahan Wad','slug'=>'warded','limit'=>'1'],
            ['name'=>'Kematian Keluarga','slug'=>'family_death','limit'=>'1'],
            ['name'=>'Haji dan Umrah','slug'=>'hajj_and_umra','limit'=>'1'],
        ];
    }

    public function application()
    {
        return $this->hasOne(Application::class);
    }
}
