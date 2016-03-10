<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
