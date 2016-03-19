<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setUnread()
    {
        $this->seen = false;
        $this->save();
    }

    public function setRead()
    {
        $this->seen = true;
        $this->save();
    }


    public static function send_notification($user_id, $description, $link)
    {
        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->notification_description = $description;
        $notification->notification_link = $link;
        $notification->save();
    }

}
