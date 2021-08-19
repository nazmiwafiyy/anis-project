<?php

namespace App;

use App\User;
use App\Application;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $guarded = ['id'];

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'],'UTC')->setTimezone('Asia/Kuala_Lumpur')->format('d-m-Y g:i A');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function approved_by(){
        return $this->hasOne(User::class,'id','user_id');
    }

    // public function approved_by_welfare_social_bureaus(){
    //     return $this->hasOne(User::class,'id','user_id')->where;
    // }
}
