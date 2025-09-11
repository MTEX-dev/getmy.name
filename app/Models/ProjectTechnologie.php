<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTechnologie extends Model
{
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
