<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class TripPlan
 *
 * @property $id
 * @property $start_from
 * @property $finish_to
 * @property $trip_type
 * @property $status
 * @property $post_id
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostWoPlanTrip extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'post_wo_plan_trip';

    protected $fillable = [
        'start_from', 'finish_to', 'trip_type', 'post_id'
    ];
    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    const ROUTE_POS = 3;

    const ROUTE_NAME = 'plan-trips';
}
