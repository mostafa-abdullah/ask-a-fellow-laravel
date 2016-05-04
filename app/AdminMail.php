<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminMail extends Model
{
    protected $table = 'admin_mails';

    public function sender()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function recipients()
    {
        return $this->belongsToMany('App\User','mail_recipients','mail_id');
    }

}
