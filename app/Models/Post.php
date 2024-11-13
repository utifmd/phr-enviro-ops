<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
 * @property $imageUrl
 * @property $imageUrls
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
        'title', 'description', 'type', 'user_id'
    ];
    protected $perPage = 20;

    function imageUrl(): HasOne
    {
        return $this->hasOne(
            ImageUrl::class, 'post_id', 'id'
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

    function workTrip(): HasOne
    {
        return $this->hasOne(
            WorkTrip::class, 'post_id', 'id'
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
