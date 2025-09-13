<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProjectFeature extends Model
{
    use  HasUuids;
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
