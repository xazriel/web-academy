<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = [
    'user_id', 
    'academy_id', 
    'score', 
    'correct_answers', 
    'total_questions'
];
}
