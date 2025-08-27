<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasUuids;

    protected $fillable = [
        'name',
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
    
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}