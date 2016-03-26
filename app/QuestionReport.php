<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionReport extends Model
{
    //
    protected $table = 'questions_reports';

    public function reporter()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

}
