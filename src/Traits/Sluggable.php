<?php

namespace SE\SDK\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Sluggable
{
    protected $sluggableInput = 'name';
    protected $slugInput = 'slug';

    public static function boot()
    {
        parent::boot();

        static::creating(function(Model $item) {
            $slug = Str::slug($this->{$this->sluggableInput});
            $count = static::whereRaw("{$this->slugInput} RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $item->{$this->slugInput} = $count ? "{$slug}-{$count}" : $slug;
        });

    }
}