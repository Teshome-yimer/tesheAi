<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'score',
        'total',
        'answers',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'answers'      => 'array',
            'completed_at' => 'datetime',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPercentageAttribute(): int
    {
        return $this->total > 0 ? (int) round($this->score / $this->total * 100) : 0;
    }
}
