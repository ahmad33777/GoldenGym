<?php

namespace App\Models;

use App\Models\Trainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 class schedule extends Model
{ 
     
    protected $table = 'schedules';

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'time_in',
        'time_out',
     ];


     
    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'schedule_trainers', 'schedule_id', 'trainer_id');
    }
}
