<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
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
 * @property $users
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

    protected $fillable = [
        'date', 'time', 'act_name', 'act_process', 'act_unit', 'act_value', 'area_name', 'area_loc', 'user_id'
    ];

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
