<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;



    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'trainer_id',
        'subscriber_id'
     ];
}
