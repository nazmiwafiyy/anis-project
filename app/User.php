<?php

namespace App;

use App\Profile;
use App\Application;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'created_at' => 'datetime:d-m-Y g:i A',
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'],'UTC')->setTimezone('Asia/Kuala_Lumpur')->format('d-m-Y g:i A');
    }

    protected $dates = ['deleted_at'];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute()
    {
        return Storage::url('avatars/'.$this->id.'/'.$this->avatar); 
    }

    public function adminlte_profile_url()
    {
        return 'profile';
    }

    public function adminlte_image()
    {
        if($this->profile && $this->profile->picture ){
            return Storage::url('profiles/'.$this->id.'/'.$this->profile->picture);
        }else{
            return $this->getAvatarUrlAttribute();
        }
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function approvalLevel()
    {
        if($this->hasRole('super-admin')){
            return 99;
        }elseif($this->hasPermissionTo('approval-head-department')){
            return 1;
        }elseif($this->hasPermissionTo('approval-welfare-social-bureaus')){
            return 2;
        }elseif($this->hasPermissionTo('approval-secretary-sports-welfare')){
            return 3;
        }elseif($this->hasPermissionTo('approval-treasurer')){
            return 4;
        }else{
            return 0;
        }
    }
}
