<?php

namespace App\Models;

use App\Models\Trainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    protected $table = 'attendances';
    use SoftDeletes;
    use HasFactory;


    protected $fillable = [
        'user_id ',
        'attendance_time',
        'date',
        'status',
        'leave_time',
        'order_status',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}