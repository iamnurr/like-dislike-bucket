<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DislikeCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
    ];

    public function dislikeCountable()
    {
        return $this->morphTo();
    }
}
