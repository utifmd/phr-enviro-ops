<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
 * @property $user_id
 * @property $couple_id
 * @property $created_at
 * @property $updated_at
 *
 * RELATION
 * @property $post
 * @property $user
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
        'type', 'date', 'time', 'act_name', 'act_process', 'act_unit', 'act_value', 'area_name', 'area_loc', 'status', 'post_id', 'user_id', 'created_at'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*public function couple(): HasOne
    {
        return $this->hasOne(
            WorkTrip::class, 'couple_id', 'couple_id'
        ); //->where('type', '=', WorkTripTypeEnum::ACTUAL->value)
    }*/

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
