<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'url',
        'image',
        'github_url',
        'live_demo_url',
        'role',
        'challenges',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technologies()
    {
        return $this->hasMany(ProjectTechnology::class);
    }

    public function features()
    {
        return $this->hasMany(ProjectFeature::class);
    }
}