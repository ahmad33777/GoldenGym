<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;




    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function Subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}