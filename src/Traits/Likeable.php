<?php
namespace NrType\LikeDislike\Traits;

use Illuminate\Support\Facades\DB;
use NrType\LikeDislike\Models\Like;
use NrType\LikeDislike\Models\LikeCounter;

trait Likeable {

    // like related part

    private function authId ()
    {
        return auth()->user()->id;
    }

    public function hasLike ()
    {
        return $this->likes->contains('user_id', $this->authId());
    }

    public function removeLike ()
    {
        $like = $this->likes->firstWhere('user_id', $this->authId());

        if(!empty($like)){
            $like->delete();
            $this->decrementLikeCount();
            return true;
        }
        return false;
    }

    public function like ()
    {
        if($this->hasLike()){
            return 'Liked';
        }
        if($this->dislikeDependency()){
            $this->removeDislike();
        }
        if ($this->likes()->create(['user_id' => $this->authId()])) {
            $this->incrementLikeCount();
            return true;
        }
        return false;
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // likers

    public function likers (array $fields = null)
    {
        if (empty($fields)) {
            $fields = ['id','name'];
        }
        $likerIds = $this->likes()->pluck('user_id');
        $likers = DB::table('users')
            ->select($fields)
            ->whereIn('id',$likerIds)
            ->get();
        return $likers;
    }

    // like count related part

    private function incrementLikeCount ()
    {
        $hasCount = $this->likeCounter()->first();
        if ($hasCount) {
            $hasCount->forceFill(['count' => $hasCount->count +1])->update();
            return true;
        }
        if ($this->likeCounter()->create(['count' => 1])) {
            return true;
        }
        return false;
    }

    private function decrementLikeCount ()
    {
        $hasCount = $this->likeCounter()->first();
        if ($hasCount) {
            if ($hasCount->count != 0) {
                $hasCount->forceFill(['count' => $hasCount->count -1])->update();
            }
            return true;
        }
        return false;
    }

    public function likeCounter()
    {
        return $this->morphOne(LikeCounter::class, 'likecountable');
    }

    private function dislikeDependency ()
    {
        if(method_exists(static::class, 'likeDependency')){
            return true;
        }
        return false;
    }


}
