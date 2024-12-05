<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WorkTripNote extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    protected $table = 'work_trip_notes';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'message', 'post_id'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
