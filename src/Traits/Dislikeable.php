<?php
namespace NrType\LikeDislike\Traits;

use Illuminate\Support\Facades\DB;
use NrType\LikeDislike\Models\Dislike;
use NrType\LikeDislike\Models\DislikeCounter;

trait Dislikeable {

    public function hasDislike ()
    {
        return $this->dislikes->contains('user_id', $this->authUserId());
    }

    public function removeDislike ()
    {
        $dislike = $this->dislikes()->firstWhere('user_id', $this->authUserId());

        if(!empty($dislike)){
            $dislike->delete();
            $this->decrementDislikeCount();
            return true;
        }
        return false;
    }

    public function dislike ()
    {
        if($this->hasDislike()){
            return 'Disliked';
        }
        if($this->likeDependency()){
            $this->removeLike();
        }
        if ($this->dislikes()->create(['user_id' => $this->authUserId()])) {
            $this->incrementDislikeCount();
            return true;
        }
        return false;
    }

    public function dislikes()
    {
        return $this->morphMany(Dislike::class, 'dislikeable');
    }

    public function dislikers (array $fields = null)
    {
        if (empty($fields)) {
            $fields = ['id','name'];
        }
        $dislikerIds = $this->dislikes()->pluck('user_id');
        $dislikers = DB::table('users')
            ->select($fields)
            ->whereIn('id',$dislikerIds)
            ->get();
        return $dislikers;
    }

    // dislike count related part

    private function incrementDislikeCount ()
    {
        $hasCount = $this->dislikeCounter()->first();
        if ($hasCount) {
            $hasCount->forceFill(['count' => $hasCount->count +1])->update();
            return true;
        }
        if ($this->dislikeCounter()->create(['count' => 1])) {
            return true;
        }
        return false;
    }

    private function decrementDislikeCount ()
    {
        $hasCount = $this->dislikeCounter()->first();
        if ($hasCount) {
            if ($hasCount->count != 0) {
                $hasCount->forceFill(['count' => $hasCount->count -1])->update();
            }
            return true;
        }
        return false;
    }

    public function dislikeCounter()
    {
        return $this->morphOne(DislikeCounter::class, 'dislikecountable');
    }

    private function likeDependency ()
    {
        if(method_exists(static::class, 'dislikeDependency')){
            return true;
        }
        return false;
    }

    private function authUserId ()
    {
        if(method_exists(static::class, 'authId')){
            return $this->authId();
        }
        return auth()->id();
    }
}
