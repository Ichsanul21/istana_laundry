<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description', 'image',
        'discount_type', 'discount_value', 'start_date', 'end_date', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(fn ($promo) => $promo->slug ??= Str::slug($promo->title));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }
}
