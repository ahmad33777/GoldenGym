<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Subscriber extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

    protected $table = 'subscribers';


    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }


    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
    ];


    public function products()
    {
        return $this->hasMany(Sale::class);
    }
}