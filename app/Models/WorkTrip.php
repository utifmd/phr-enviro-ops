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
 * @property $type
 * @property $date
 * @property $time
 * @property $act_name
 * @property $act_process
 * @property $act_unit
 * @property $act_value
 * @property $area_name
 * @property $area_loc
 * @property $post_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkTrip extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'work_trips';

    protected $fillable = [
        'type', 'date', 'time', 'act_name', 'act_process', 'act_unit', 'act_value', 'area_name', 'area_loc', 'post_id'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
