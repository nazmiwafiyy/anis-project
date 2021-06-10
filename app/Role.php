<?php

namespace App;

use App\Module;
use App\Permission;


class Role extends \Spatie\Permission\Models\Role
{
    protected $casts = [
        'created_at' => 'datetime:d-m-Y g:i A',
    ];
}
