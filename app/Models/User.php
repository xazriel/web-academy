<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'role',
        'phone',          // Tambahan
        'gender',         // Tambahan
        'birth_date',     // Tambahan
        'city',           // Tambahan
        'occupation_status', // Tambahan
        'school_level',   // Tambahan
        'institution_name', // Tambahan
        'major',          // Tambahan
        'company_name',   // Tambahan
        'job_title',      // Tambahan
        'about_me',       // Tambahan
        'interests',      // Tambahan
        'portfolio_link',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    protected function isAdmin(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
    return \Illuminate\Database\Eloquent\Casts\Attribute::make(
        get: fn () => $this->role === 'admin',
    );
    }

    public function completedLessons()
    {
    return $this->belongsToMany(Lesson::class, 'lesson_user')->withTimestamps();
    }
    public function discussions()
    {
    return $this->hasMany(Discussion::class);
    }
    public function certificates()
    {
    return $this->hasMany(Certificate::class);
    }
}
