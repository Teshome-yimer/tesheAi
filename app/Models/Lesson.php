<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LessonFile;
use App\Models\LessonProgress;

class Lesson extends Model
{
    protected $fillable = [
        'section_id', 'course_id', 'title', 'slug', 'video_url', 'video_path', 'video_type',
        'description', 'duration_minutes', 'order', 'is_free_preview',
    ];

    protected $casts = ['is_free_preview' => 'boolean'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function files()
    {
        return $this->hasMany(LessonFile::class)->orderBy('order');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
