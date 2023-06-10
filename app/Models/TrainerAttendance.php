<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainerAttendance extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'trainer_attendances';

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'phone',
    // ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'trainer_id' ,
        'id'
      ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

}