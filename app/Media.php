<?php
namespace App;

use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use PimpableTrait;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order_column');
        });
    }
}
