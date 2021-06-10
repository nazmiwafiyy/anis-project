<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id']; 
    
    public function files()
    {
        return $this->hasMany(File::class);
    }
}
