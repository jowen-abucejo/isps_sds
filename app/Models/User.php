<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail,CanResetPassword
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_id',
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $to_manage;

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function isAdmin(){
        if($this->user_type === 'admin'){
            $this->to_manage = Scholarship::select('scholarship_code', 'description')->orderBy('active', 'asc')->orderBy('description', 'asc')->orderBy('created_at', 'asc')->groupBy('scholarship_code')->groupBy('description')->get();
            return true;
        }
        return false;
    }

    public function isStudent(){
        if($this->user_type === 'student')
            return true;
        return false;
    }
}
