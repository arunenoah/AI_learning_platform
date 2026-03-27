<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'icon',
        'type',
        'requirement_value',
        'requirement_type',
    ];

    protected $casts = [
        'requirement_value' => 'integer',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
