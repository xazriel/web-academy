<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = ['user_id', 'academy_id', 'lesson_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}