<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarpetInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'whatsapp',
        'notes',
        'photo_path',
        'token',
        'status',
        'overall_condition',
        'cleanliness_score',
        'findings',
        'recommendation',
        'summary',
        'raw_response',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'findings' => 'array',
            'cleanliness_score' => 'integer',
        ];
    }

    public function getWaNumberAttribute(): ?string
    {
        return preg_replace('/^0/', '62', (string) $this->whatsapp);
    }

    public function getPhotoUrlAttribute(): string
    {
        return asset('storage/'.$this->photo_path);
    }
}
