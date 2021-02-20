<?php


namespace App\Traits;


use App\User;
use Illuminate\Support\Facades\Auth;

trait VoteTraits
{
    public function votes()
    {
        return $this->morphToMany(User::class,'voteable');
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('votes',-1);
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('votes',1);
    }

    public function getIsUpVoteAttribute()
    {
        $upVoteCount = $this->votes()->where(['user_id'=>Auth::id(),'votes'=>1])->count();

        return $upVoteCount ?  true : false;
    }

    public function getIsDownVoteAttribute()
    {
        $downVoteCount = $this->votes()->where(['user_id'=>Auth::id(),'votes'=>-1])->count();

        return $downVoteCount ? true : false;
    }
}
