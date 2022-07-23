<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leader_id',
        'year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class);
    }


}
