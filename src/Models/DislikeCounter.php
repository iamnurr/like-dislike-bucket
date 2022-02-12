<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Model;

class DislikeCounter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'dislike_counters';

    protected $fillable = [
        'count',
    ];

    public function dislikeCountable()
    {
        return $this->morphTo();
    }
}
