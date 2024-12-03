<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class workTripNote extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    protected $table = 'work_trip_notes';

    public $incrementing = false;

    protected $fillable = [
        'message', 'post_id'
    ];

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
