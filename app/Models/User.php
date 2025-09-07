<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasUuids;
    use HasApiTokens;

    protected $fillable = [
        'name',
        'username',
        'title',
        'bio',
        'about_me',
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

    public function profileData(): array
    {
        $this->load(['skills', 'projects', 'socials', 'education', 'experiences']);

        return [
            'name' => $this->name,
            'username' => $this->username,
            'title' => $this->title,
            'bio' => $this->bio,
            'location' => $this->location,
            'avatar_url' => $this->getAvatarUrl(),
            'email' => $this->email,
            'about_me' => $this->about_me,
            'skills' => $this->skills->pluck('name')->toArray(),
            'projects' => $this->projects->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'name' => $project->title,
                    'description' => $project->description,
                    'url' => $project->url,
                    'image_path' => $project->image_path ? Storage::url($project->image_path) : null,
                ];
            })->toArray(),
            'experiences' => $this->experiences->map(function ($experience) {
                return [
                    'id' => $experience->id,
                    'title' => $experience->title,
                    'company' => $experience->company,
                    'location' => $experience->location,
                    'start_date' => $experience->start_date,
                    'end_date' => $experience->end_date,
                    'description' => $experience->description,
                ];
            })->toArray(),
            'education' => $this->education->map(function ($education) {
                return [
                    'id' => $education->id,
                    'school' => $education->school,
                    'degree' => $education->degree,
                    'field_of_study' => $education->field_of_study,
                    'start_date' => $education->start_date,
                    'end_date' => $education->end_date,
                    'description' => $education->description,
                ];
            })->toArray(),
            'socials' => $this->socials
                ? $this->socials->only(['github', 'linkedin', 'twitter', 'personal_website'])
                : [],
            'api_request_count' => $this->getApiRequestCount(),
        ];
    }
}