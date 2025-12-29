<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'academy_id',
        'chapter_id',
        'section_title',
        'title',
        'slug',          
        'content',       
        'video_url',
        'order'
    ];

    /**
     * Materi ini milik Academy tertentu
     */
    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }

    public function getYoutubeIdAttribute()
    {
    if (!$this->video_url) return null;
    
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->video_url, $match);
    
    return $match[1] ?? null;
    }

    public function quizzes() {
    return $this->hasMany(Quiz::class);
}

}