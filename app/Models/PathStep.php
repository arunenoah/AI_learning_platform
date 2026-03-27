<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PathStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'learning_path_id',
        'resource_id',
        'order',
        'title',
        'instructions',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
