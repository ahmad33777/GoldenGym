<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'subscriptions';

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class,'subscription_id');
    }

    protected $hidden = [
         'created_at',
        'updated_at',
        'deleted_at',
    ];

    

}