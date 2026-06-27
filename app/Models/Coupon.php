<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'course_id',
        'max_uses', 'used_count', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isValid($courseId = null): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->course_id && $courseId && $this->course_id != $courseId) return false;
        return true;
    }

    public function calculateDiscount(float $price): float
    {
        if ($this->type === 'percentage') {
            return round($price * ($this->value / 100), 2);
        }
        return min($this->value, $price);
    }
}
