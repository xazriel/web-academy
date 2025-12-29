<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    // Tambahkan parent_id ke dalam fillable
    protected $fillable = ['user_id', 'academy_id', 'lesson_id', 'body', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi untuk mendapatkan balasan (replies) dari sebuah thread.
     */
    public function replies()
    {
        return $this->hasMany(Discussion::class, 'parent_id')->latest();
    }

    /**
     * Relasi balik untuk mengetahui ini balasan dari thread mana.
     */
    public function parent()
    {
        return $this->belongsTo(Discussion::class, 'parent_id');
    }
}