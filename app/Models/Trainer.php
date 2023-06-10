<?php

namespace App\Models;

use App\Models\Check;
use App\Models\Leave;
use App\Models\Latetime;
use App\Models\Overtime;
use App\Models\schedule;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainer extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    protected $table = 'trainers';

    protected $fillable = [
        'name',
        'email',
        'phone',
     ];


    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'deleted_at',
        'image',
        'email_verified_at',
    ];

    public function check()
    {
        return $this->hasMany(Check::class);
    }

    public function attendance()
    {
        return $this->hasMany(TrainerAttendance::class);
    }
   
  
    
    public function schedules()
    {
        return $this->belongsToMany(schedule::class, 'schedule_trainers', 'trainer_id', 'schedule_id');
    }


    public function ratings(){
        return $this->hasMany(Rating::class);
    }

}