<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'unit', 'icon', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(fn ($service) => $service->slug ??= Str::slug($service->name));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
