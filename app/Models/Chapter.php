<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Chapter extends Model
{
    protected $fillable = ['academy_id', 'title', 'order'];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function academy(): BelongsTo
    {
        return $this->belongsTo(Academy::class);
    }
}