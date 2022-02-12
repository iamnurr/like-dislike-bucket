<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Model;

class LikeCounter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'like_counters';

    protected $fillable = [
        'count',
    ];

    public function likeCountable()
    {
        return $this->morphTo();
    }
}
