<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $appends =['avatar'];

    protected $fillable = [
        'name', 'email', 'password',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Question::class,'favourites');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class,'voteable');
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class,'voteable');
    }


    public function voteQuestion(Question $question,$vote)
    {
        $voteQuestions = $this->voteQuestions();
        return $this->_vote($voteQuestions,$question,$vote);
    }

    public function voteAnswer(Answer $answer,$vote)
    {
        $voteAnswers = $this->voteAnswers();
        return $this->_vote($voteAnswers,$answer,$vote);
    }

    public function _vote($relationship,$model,$vote)
    {
        if($relationship->where('voteable_id',$model->id)->exists()){
            $relationship->updateExistingPivot($model,['votes'=>$vote]);
        }
        else{
            $relationship->attach($model,['votes'=>$vote]);
        }

        $model->load('votes');
        $downVotes = (int) $model->downVotes()->sum('votes');
        $upVotes = (int) $model->upVotes()->sum('votes');

        $model->vote_counts = $downVotes + $upVotes;
        $model->save();

        return $model->vote_counts;
    }


    public function getAvatarAttribute()
    {
        $email = "someone@somewhere.com";
        $size = 20;

        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "&s=" . $size;

        return $grav_url;
    }

}

