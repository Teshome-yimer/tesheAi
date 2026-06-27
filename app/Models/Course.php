<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'what_you_learn', 'thumbnail',
        'preview_video', 'price_etb', 'price_usd', 'original_price_etb',
        'original_price_usd', 'is_published', 'is_featured',
        'total_lessons', 'total_hours', 'level', 'language',
    ];

    protected $casts = [
        'what_you_learn' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discountPercentageEtb(): int
    {
        if ($this->original_price_etb && $this->original_price_etb > $this->price_etb) {
            return (int) round((($this->original_price_etb - $this->price_etb) / $this->original_price_etb) * 100);
        }
        return 0;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
