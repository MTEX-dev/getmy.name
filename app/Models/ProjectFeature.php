<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFeature extends Model
{
    protected $table = 'project_features';

    protected $fillable = [
        'project_id',
        'feature',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
