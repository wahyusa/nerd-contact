<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'avatar',
        'birth_date',
        'zodiac_id',
        'description',
        'social_links',
        'tags',
        'last_meet',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'social_links' => 'array',
        'tags' => 'array',
        'last_meet' => 'datetime',
    ];

    // Model Accessor
    public function getFullNameAttribute(): string 
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAgeAttribute(): ?int 
    {
        return $this->birth_date?->age;
    }

    // Auto-detect zodiac from birth date
    public function getDetectedZodiacAttribute(): ?Zodiac
    {
        if (!$this->birth_date) return null;
        
        return Zodiac::detectFromDate($this->birth_date);
    }

    // Relationship
    public function zodiac(): BelongsTo 
    {
        return $this->belongsTo(Zodiac::class);
    }

    // Scopes
    public function scopeByTag($query, string $tag) 
    {
        return $query->whereJsonContains('tags', $tag);
    }

    public function scopeByZodiac($query, $zodiacId)
    {
        return $query->where('zodiac_id', $zodiacId);
    }
}
