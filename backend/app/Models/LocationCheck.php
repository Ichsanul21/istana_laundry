<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationCheck extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'address',
        'lat',
        'lng',
        'nearest_branch_id',
        'distance_km',
        'is_within_radius',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
            'distance_km' => 'decimal:3',
            'is_within_radius' => 'boolean',
        ];
    }

    public function nearestBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'nearest_branch_id');
    }
}
