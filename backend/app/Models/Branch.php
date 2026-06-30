<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'address',
        'lat',
        'lng',
        'radius_km',
        'phone',
        'is_active',
        'open_hours',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
            'radius_km' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function locationChecks(): HasMany
    {
        return $this->hasMany(LocationCheck::class, 'nearest_branch_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNearest($query, $lat, $lng)
    {
        return $query->get()->map(function ($branch) use ($lat, $lng) {
            $branch->distance = round(self::haversine($lat, $lng, $branch->lat, $branch->lng), 3);
            return $branch;
        })->sortBy('distance')->first();
    }

    public function scopeWithinRadius($query, $lat, $lng, $radius = 3)
    {
        return $query->get()->filter(function ($branch) use ($lat, $lng, $radius) {
            $distance = self::haversine($lat, $lng, $branch->lat, $branch->lng);
            $branch->distance = round($distance, 3);
            return $distance <= $radius;
        })->sortBy('distance')->values();
    }

    public static function haversine($lat1, $lng1, $lat2, $lng2): float
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
