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
 * @property $from_facility
 * @property $from_pit
 * @property $to_facility
 * @property $type
 * @property $work_trip_detail_id
 * @property $created_at
 *
 * RELATION
 * @property $workTripDetail
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WorkTripDetailOut extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'work_trip_details_out';

    protected $fillable = [
        'from_facility',
        'from_pit',
        'to_facility',
        'type',
        'work_trip_detail_id',
    ];

    public function workTripDetail(): BelongsTo
    {
        return $this->belongsTo(WorkTripDetail::class);
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
