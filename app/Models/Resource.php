<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'learning_reason',
        'category',
        'type',
        'url',
        'content',
        'duration_minutes',
        'difficulty_level',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'difficulty_level' => 'integer',
        'duration_minutes' => 'integer',
    ];

    public function pathSteps(): HasMany
    {
        return $this->hasMany(PathStep::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function completedByUsers()
    {
        return $this->userProgress()->where('is_completed', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }
}
