<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @property $id
 * @property $transporter
 * @property $driver
 * @property $police_number
 * @property $time_in
 * @property $time_out
 * @property $from_pit
 * @property $from_facility
 * @property $to_facility
 * @property $type
 * @property $volume
 * @property $tds
 * @property $load
 * @property $area_name
 * @property $remarks
 * @property $post_id
 * @property $user_id
 * @property $created_at
 *
 * RELATION
 * @property $post
 * @property $user
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkTripOutDetail extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'work_trip_out_details';

    protected $fillable = [
        'transporter',
        'driver',
        'police_number',
        'time_in',
        'time_out',
        'from_pit',
        'from_facility',
        'to_facility',
        'type',
        'volume',
        'tds',
        'load',
        'area_name',
        'remarks',
        'post_id',
        'user_id',
        'created_at'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
