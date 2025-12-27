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
        'section_title',
        'title',
        'slug',          // Tambahkan ini
        'content',       // Tambahkan ini untuk isi materi teks
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
}