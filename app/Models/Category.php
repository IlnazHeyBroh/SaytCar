<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const SLUG_NEW = 'new';
    public const SLUG_USED = 'used';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function bbs()
    {
        return $this->hasMany(Bb::class);
    }

    public function scopeListingTypes($query)
    {
        return $query
            ->whereIn('slug', [self::SLUG_NEW, self::SLUG_USED])
            ->orderByRaw(
                "case when slug = 'new' then 0 when slug = 'used' then 1 else 2 end"
            );
    }
}
