<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function likers ()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
