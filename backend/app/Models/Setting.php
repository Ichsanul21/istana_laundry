<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    public static function getValue($key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }
}
