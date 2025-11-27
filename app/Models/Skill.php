<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
