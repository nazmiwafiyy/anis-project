<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'position_id', 'department_id','fullname','identity_no','phone_no','picture'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
