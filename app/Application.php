<?php

namespace App;

use App\File;
use App\Type;
use App\User;
use App\Approval;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id']; 

    protected $casts = [
        'created_at' => 'datetime:d-m-Y g:i A',
    ];
    
    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function approvals(){
        return $this->hasMany(Approval::class);
    }
}
