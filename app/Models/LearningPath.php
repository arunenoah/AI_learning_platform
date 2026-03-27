<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'icon',
        'difficulty',
        'estimated_hours',
        'is_published',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'estimated_hours' => 'integer',
        'order' => 'integer',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(PathStep::class)->orderBy('order');
    }

    public function resources(): BelongsToMany
    {
        return $this->belongsToMany(Resource::class, 'path_steps')
            ->withPivot(['order', 'title', 'instructions'])
            ->withTimestamps();
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserPathProgress::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getTotalStepsAttribute(): int
    {
        return $this->steps()->count();
    }
}
