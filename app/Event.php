<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function invites()
    {
        return $this->belongsToMany(Invite::class);
    }

    public function participations()
    {
        return $this->belongsToMany(Participation::class);
    }
}
