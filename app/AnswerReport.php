<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerReport extends Model
{
    //
    protected $table = 'answers_reports';

    public function reporter()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function answer()
    {
        return $this->belongsTo('App\Answer');
    }
}
