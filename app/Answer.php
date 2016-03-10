<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function responder()
    {
        return $this->belongsTo('App\User','responder_id');
    }

    public function upvotes()
    {
        return $this->hasMany('App\AnswerVote')->where('type','=',0)->get();
    }

    public function downvotes()
    {
        return $this->hasMany('App\AnswerVote')->where('type','=',1)->get();
    }

    public function course()
    {
        return $this->question()->course();
    }


}
