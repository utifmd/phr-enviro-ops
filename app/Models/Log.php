<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @property $id
 * @property $event
 * @property $area
 * @property $influence_table
 * @property $influence_table_id
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
class Log extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'work_trip_infos';

    protected $fillable = [
        'event', 'highlight', 'notification_count', 'area', 'refer_to_table', 'refer_to_table_id', 'user_id'
    ];
    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
