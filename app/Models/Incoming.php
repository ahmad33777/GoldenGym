<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incoming extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'incomings';


    protected $hidden = [
        'id',
        'created_at',
       'updated_at',
       'deleted_at',
   ];
    public function emp()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}