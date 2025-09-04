<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasUuids;

    protected $fillable = [
        'name',
        'username',
        'title',
        'bio',
        'location',
        'email',
        'password',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function avatar(): string
    {
        return $this->avatar_path
            ? Storage::url($this->avatar_path)
            : 'https://ui-avatars.com/api/?name=' .
                strtolower(trim($this->name));
    }

    public function getAvatarUrl(): string
    {
        if ($this->avatar_path) {
            return URL::to(Storage::url($this->avatar_path));
        }

        return 'https://ui-avatars.com/api/?name=' . strtolower(trim($this->name));
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function socials()
    {
        return $this->hasOne(Social::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function getApiRequestCount()
    {
        return $this->hasMany(ApiRequest::class)->count();
    }
}