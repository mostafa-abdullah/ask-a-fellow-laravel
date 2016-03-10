<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    public function major()
    {
        return $this->belongsToMany('App\Major');
    }

    public function questions($semester = null)
    {
        if($semester)
        {
            return $this->hasMany('App\Question')->where('semester','=',$semester)->get();
        }
        else
        {
            return $this->hasMany('App\Question');
        }
    }

    public function subscribed_users()
    {
        return $this->belongsToMany('App\User','subscribe');
    }


}
