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
 * @property $company_id
 * @property $vehicle_type
 * @property $vehicle_id
 * @property $man_power_id
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
class PostWoInfo extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'post_wo_info';

    protected $fillable = [
        'company_id', 'vehicle_type', 'vehicle_id', 'man_power_id', 'start_plan', 'end_plan', 'shift', 'area', 'post_id'
    ];

    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function operator(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function crew(): HasOne
    {
        return $this->hasOne(ManPower::class, 'id', 'man_power_id');
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
