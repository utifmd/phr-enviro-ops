<?php

namespace App\Models;

use App\Utils\ActNameEnum;
use App\Utils\WorkTripTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * Class Post
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $type
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * # RELATIONAL
 * @property $information
 * @property $planOrder
 * @property $planTrips
 * @property $workTrip
 * @property $workTrips
 * @property $imageUrl
 * @property $imageUrls
 * @property $user
 * @property $remarks
 * @property $details
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Post extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'posts';

    protected $fillable = [
        'title', 'description', 'type', 'user_id', 'operator_id', 'created_at'
    ];
    protected $perPage = 6;

    function imageUrl(): HasOne
    {
        return $this->hasOne(
            ImageUrl::class, 'post_id', 'id'
        );
    }

    function remarks(): HasOne
    {
        return $this->hasOne(
            WorkTripNote::class, 'post_id', 'id'
        );
    }

    function imageUrls(): HasMany
    {
        return $this->hasMany(
            ImageUrl::class, 'post_id', 'id'
        );
    }

    function information(): HasOne
    {
        return $this->hasOne(
            Information::class, 'post_id', 'id'
        );
    }

    function planTrips(): HasMany
    {
        return $this->hasMany(
            PlanTrip::class, 'post_id', 'id'
        );
    }

    function planOrder(): HasOne
    {
        return $this->hasOne(
            PlanOrder::class, 'post_id', 'id'
        );
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function operator(): HasOne
    {
        return $this->hasOne(
            Operator::class, 'id', 'operator_id'
        );
    }

    function workTrip(): HasOne
    {
        return $this->hasOne(
            WorkTrip::class, 'post_id', 'id'
        );
    }

    function workTrips(): HasMany
    {
        return $this->hasMany(WorkTrip::class, 'post_id', 'id')
            ->where('type', WorkTripTypeEnum::ACTUAL->value)
            ->orderByDesc('time');
    }

    function details(): HasMany
    {
        return $this->hasMany(WorkTripDetail::class, 'post_id', 'id')
            ->where('type', ActNameEnum::Incoming->value);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    const ROUTE_POS = 0;

    const ROUTE_NAME = 'posts';
}
