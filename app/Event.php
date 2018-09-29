<?php
namespace App;

use Jedrzej\Pimpable\PimpableTrait;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use PimpableTrait;

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function invites()
    {
        return $this->belongsToMany(Invite::class);
    }

    public function participations()
    {
        return $this->belongsToMany(Participation::class);
    }
}
