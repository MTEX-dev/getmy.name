<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'github',
        'linkedin',
        'twitter',
        'personal_website',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}