<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class WorkOrder
 *
 * @property $id
 * @property $shift
 * @property $is_rig
 * @property $status
 * @property $ids_wellname
 * @property $post_id
 * @property $created_at
 * @property $updated_at
 *
 * RELATION
 * @property $company
 * @property $vehicle
 * @property $manPowers
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostWo extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $table = "post_wo";

    public $incrementing = false;

    protected $fillable = [
        'shift', 'is_rig', 'status', 'ids_wellname', 'post_id', 'created_at'
    ];
    protected static function booted(): void
    {
        self::creating(function ($table) {
            $table->id = Str::uuid();
        });
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function manPowers(): HasMany
    {
        return $this->hasMany(ManPower::class, 'id', 'man_power_id');
    }

    const ROUTE_NAME = 'workorders';

    public const SELECTED_YEAR_MONTH_NAME = "SELECTED_YEAR_MONTH_SESSION";
}
