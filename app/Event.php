<?php
namespace App;

use Jedrzej\Pimpable\PimpableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Event extends BaseModel implements HasMedia
{
    use PimpableTrait;
    use HasMediaTrait;

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
