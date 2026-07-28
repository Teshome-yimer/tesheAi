<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonFile extends Model
{
    protected $fillable = [
        'lesson_id', 'course_id', 'title', 'file_path',
        'file_type', 'file_size', 'is_free', 'order',
    ];

    protected $casts = ['is_free' => 'boolean'];

    public function lesson() { return $this->belongsTo(Lesson::class); }
    public function course() { return $this->belongsTo(Course::class); }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes < 1024)       return $bytes . ' B';
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    public function getIconAttribute(): string
    {
        return match($this->file_type) {
            'pdf'  => '📄',
            'doc', 'docx' => '📝',
            'zip', 'rar'  => '📦',
            'mp3', 'wav'  => '🎵',
            'jpg', 'png'  => '🖼️',
            default       => '📎',
        };
    }
}
