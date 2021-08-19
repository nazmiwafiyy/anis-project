<?php

namespace App;

use App\Module;
use App\Permission;
use Illuminate\Support\Carbon;


class Role extends \Spatie\Permission\Models\Role
{
    // protected $casts = [
    //     'created_at' => 'datetime:d-m-Y g:i A',
    // ];

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'],'UTC')->setTimezone('Asia/Kuala_Lumpur')->format('d-m-Y g:i A');
    }
}
