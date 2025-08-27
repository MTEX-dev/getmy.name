<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'school',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}