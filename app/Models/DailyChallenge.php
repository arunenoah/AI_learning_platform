<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'challenge_date',
        'is_completed',
        'bonus_xp',
    ];

    protected $casts = [
        'challenge_date' => 'date',
        'is_completed' => 'boolean',
        'bonus_xp' => 'integer',
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public static function getTodayChallenge()
    {
        $today = now()->startOfDay();

        $challenge = static::whereDate('challenge_date', $today)->first();

        if (! $challenge) {
            $challenge = static::createDailyChallenge();
        }

        return $challenge;
    }

    public static function createDailyChallenge()
    {
        $today = now()->startOfDay();

        $existing = static::whereDate('challenge_date', $today)->first();
        if ($existing) {
            return $existing;
        }

        $resource = Resource::inRandomOrder()
            ->where('difficulty_level', 1)
            ->first();

        if (! $resource) {
            $resource = Resource::inRandomOrder()->first();
        }

        return static::create([
            'resource_id' => $resource->id,
            'challenge_date' => $today,
            'bonus_xp' => 50,
        ]);
    }
}
