<?php

namespace NrType\LikeDislike\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'likes';

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
