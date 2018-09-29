<?php
namespace App;

class Reward extends BaseModel
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
