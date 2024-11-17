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
 * @property $plat
 * @property $type
 * @property $vendor
 * @property $vehicleClass
 * @property $operator_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Vehicle extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'plat', 'type', 'vendor', 'vehicle_class_id', 'operator_id'
    ];

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'id', 'operator_id');
    }

    public function vehicleClass(): BelongsTo
    {
        return $this->belongsTo(VehicleClass::class, 'vehicle_class_id', 'id');
    }

    /*public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'id', 'vehicle_id');
    }*/
}
