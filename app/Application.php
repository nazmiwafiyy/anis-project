<?php

namespace App;

use App\File;
use App\Type;
use App\User;
use App\Approval;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id']; 

    protected $casts = [
        'created_at' => 'datetime:d-m-Y g:i A',
    ];

    public function getPaymentDateAttribute()
    {
        // return $this->attributes['payment_date'];
        return Carbon::parse($this->attributes['payment_date'])->format('d-m-Y');
    } 
    
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

    public function currentApproveLevel(){
        $current = 0;
        foreach($this->approvals as $approval){
            if($approval->approved_by->hasPermissionTo('approval-head-department')){
                $current = $current < 1 ? 1 : $current;
            }elseif($approval->approved_by->hasPermissionTo('approval-welfare-social-bureaus')){
                $current = $current < 2 ? 2 : $current;
            }elseif($approval->approved_by->hasPermissionTo('approval-secretary-sports-welfare')){
                $current = $current < 3 ? 3 : $current;
            }elseif($approval->approved_by->hasPermissionTo('approval-treasurer')){
                $current = $current < 4 ? 4 : $current;
            }
        }

        return $current;
    }
}
