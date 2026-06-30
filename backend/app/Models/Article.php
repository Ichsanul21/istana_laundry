<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'featured_image',
        'alt_text',
        'category_id',
        'author',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'status' => 'string',
        ];
    }

    protected static function booted(): void
    {
        static::creating(fn ($article) => $article->slug ??= Str::slug($article->title));
        static::updating(fn ($article) => $article->slug ??= Str::slug($article->title));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}
