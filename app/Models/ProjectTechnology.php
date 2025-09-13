<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectTechnology extends Model
{
    use  HasUuids;
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
