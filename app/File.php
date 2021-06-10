<?php

namespace App;

use App\Application;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'application_id',
        'path',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
