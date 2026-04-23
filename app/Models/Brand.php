<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::saving(function (Brand $brand) {
            $brand->slug = Str::slug($brand->name);
        });
    }

    public static function names()
    {
        return static::orderBy('name')->pluck('name');
    }
}
