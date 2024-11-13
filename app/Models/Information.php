<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class Order
 *
 * @property $id
 * @property $operator_id
 * @property $vehicle_type
 * @property $vehicle_id
 * @property $crew_id
 * @property $start_plan
 * @property $end_plan
 * @property $shift
 * @property $area
 * @property $post_id
 *
 * RELATION
 * @property $operator
 * @property $vehicle
 * @property $crew
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Information extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'information';

    protected $fillable = [
        'operator_id', 'vehicle_type', 'vehicle_id', 'crew_id', 'start_plan', 'end_plan', 'shift', 'area', 'post_id'
    ];

    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function operator(): HasOne
    {
        return $this->hasOne(Operator::class, 'id', 'operator_id');
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function crew(): HasOne
    {
        return $this->hasOne(Crew::class, 'id', 'crew_id');
    }

    const ROUTE_POS = 1;

    const ROUTE_NAME = 'information';

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
