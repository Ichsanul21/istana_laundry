<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'page', 'meta_title', 'meta_description',
        'og_title', 'og_description', 'og_image', 'schema_type',
    ];

    public function scopeForPage($query, $page)
    {
        return $query->where('page', $page);
    }
}
