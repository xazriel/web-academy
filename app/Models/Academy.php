<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Academy extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar data bisa disimpan ke database
    protected $fillable = [
        'title', 
        'slug', 
        'category', 
        'price', 
        'instructor_name', 
        'instructor_role', 
        'description', 
        'thumbnail'
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

public function isEnrolled()
{
    return $this->enrollments()->where('user_id', auth()->id())->exists();
}

public function quizzes()
{
    return $this->hasMany(Quiz::class);
}

}