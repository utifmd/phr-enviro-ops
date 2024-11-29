<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @property $id
 * @property $date
 * @property $time
 * @property $act_name
 * @property $act_process
 * @property $act_unit
 * @property $act_value
 * @property $area_name
 * @property $area_loc
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * RELATION
 * @property $user
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkTripInfo extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'work_trip_infos';

    protected $perPage = 10;

    protected $fillable = [
        'date', 'time', 'act_name', 'act_process', 'act_unit', 'act_value', 'area_name', 'area_loc', 'user_id'
    ];

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
