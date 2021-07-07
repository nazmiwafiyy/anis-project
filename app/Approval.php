<?php

namespace App;

use App\User;
use App\Application;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $guarded = ['id'];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function approved_by(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
