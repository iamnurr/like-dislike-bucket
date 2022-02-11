<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function dislikeable()
    {
        return $this->morphTo();
    }
}
