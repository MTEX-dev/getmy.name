<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Social extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use LogsActivity;

    protected static $logFillable = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected $fillable = [
        'user_id',
        'github',
        'linkedin',
        'twitter',
        'bluesky',
        'personal_website',
        'codepen',
        'instagram',
        'youtube_url',
        //'modrinth',
        'stackoverflow',
        'dev_to',
        'hashnode',
        'npm',
        'product_hunt',
        'polywork',
        'gitlab',
        'dribbble',
        'figma',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}