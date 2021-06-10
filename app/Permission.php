<?php

namespace App;

use App\Module;

class Permission extends \Spatie\Permission\Models\Permission
{
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}