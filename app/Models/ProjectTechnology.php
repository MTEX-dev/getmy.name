<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTechnology extends Model
{
    use  HasUuids, SoftDeletes;
    protected $table = 'project_technologies';

    protected $fillable = [
        'project_id',
        'technologie',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
