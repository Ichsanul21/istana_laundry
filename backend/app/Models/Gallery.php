<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug', 'description', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::creating(fn ($gallery) => $gallery->slug ??= Str::slug($gallery->title));
    }

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }
}
