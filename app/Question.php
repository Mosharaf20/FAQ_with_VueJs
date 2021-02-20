<?php

namespace App;

use App\Traits\VoteTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Question extends Model
{
    use  VoteTraits;

    protected $guarded = [];
    protected $appends = ['is_favourite','created_date','body_html','is_up_vote','is_down_vote'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class,'favourites');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getBodyHtmlAttribute()
    {
        return nl2br($this->body) ;
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer = $answer->id;
        $this->save();
    }

    public function Favourite()
    {
        return $this->getIsFavouriteAttribute() ? 'favourite' : '';
    }

    public function getIsFavouriteAttribute()
    {
        return $this->favourites()->where('user_id',\Auth::id())->count() > 0 ;
    }

    public function getFavoriteCountAttribute()
    {
        return $this->favourites()->count();
    }





}
