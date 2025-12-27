<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    // WAJIB: Daftarkan kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'academy_id',
        'certificate_number',
        'issued_at'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Academy
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}