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
 * @property $actual_start
 * @property $actual_finish
 * @property $km_start
 * @property $km_end
 * @property $km_actual
 * @property $km_contract
 * @property $start_working_date
 * @property $end_working_date
 * @property $total_standby_hour
 * @property $total_working_hour
 * @property $job_ticket_number
 * @property $post_id
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PlanTrip extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'plan_trips';

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
