<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'points',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function pathProgress(): HasMany
    {
        return $this->hasMany(UserPathProgress::class);
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function streak(): HasMany
    {
        return $this->hasMany(UserStreak::class);
    }

    public function currentStreak(): HasOne
    {
        return $this->hasOne(UserStreak::class);
    }

    public function completedResources()
    {
        return $this->progress()->where('is_completed', true);
    }

    public function completedPaths()
    {
        return $this->pathProgress()->where('is_completed', true);
    }

    public function passedQuizzes()
    {
        return $this->quizAttempts()->where('passed', true)->distinct('quiz_id');
    }
}

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
