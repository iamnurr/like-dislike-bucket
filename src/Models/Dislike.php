<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Model;

class Dislike extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'dislikes';

    protected $fillable = [
        'user_id',
    ];

    public function dislikeable()
    {
        return $this->morphTo();
    }
}
