<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
    ];

    public function likeCountable()
    {
        return $this->morphTo();
    }
}
