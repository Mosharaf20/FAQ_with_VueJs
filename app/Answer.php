<?php

namespace App;

use App\Traits\VoteTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Answer extends Model
{
    use VoteTraits;

    protected $guarded = [];
    protected $appends = ['body_html','best_answer','created_date','is_up_vote','is_down_vote'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($answer){
            $answer->question->increment('answer_counts');
        });

        static::deleted(function ($answer){
            $answer->question->decrement('answer_counts');
        });

    }

    public function getBodyHtmlAttribute()
    {
        return nl2br($this->body,false) ;
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'accepted' : '';
    }

    public function isBest()
    {
        return $this->id == $this->question->best_answer;
    }

    public function getBestAnswerAttribute()
    {
        return $this->isBest();
    }
}
