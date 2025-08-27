<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasUuids;

    protected $fillable = [
    ];  

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
