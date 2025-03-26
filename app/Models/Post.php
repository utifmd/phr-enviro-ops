<?php

namespace App\Models;

use App\Utils\ActNameEnum;
use App\Utils\PostFacReportTypeEnum;
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
 * @property $status
 * @property $user_id
 * @property $created_at
 * @property $updated_at
 *
 * # RELATIONAL
 * @property $information
 * @property $planOrder
 * @property $planTrips
 * @property $postRemark
 * @property $postRemarks
 * @property $postsFac
 * @property $postFacReport
 * @property $postsFacReport
 * @property $imageUrl
 * @property $imageUrls
 * @property $user
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
        'title', 'description', 'type', 'status', 'user_id', 'company_id', 'created_at'
    ];
    protected $perPage = 6;

    function postRemark(): HasOne
    {
        return $this->hasOne(
            PostRemark::class, 'post_id', 'id'
        );
    }
    public function company(): HasOne
    {
        return $this->hasOne(
            Company::class, 'id', 'company_id'
        );
    }

    function postFacReport(): HasOne
    {
        return $this->hasOne(
            PostFacReport::class, 'post_id', 'id'
        );
    }

    function postsFacReport(): HasMany
    {
        return $this->hasMany(PostFacReport::class, 'post_id', 'id')
            ->where('type', PostFacReportTypeEnum::ACTUAL->value)
            ->orderByDesc('time');
    }

    function postsFac(): HasMany
    {
        return $this->hasMany(PostFac::class, 'post_id', 'id')
            ->where('type', ActNameEnum::Incoming->value);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

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
            PostWoPlanTrip::class, 'post_id', 'id'
        );
    }

    function planOrder(): HasOne
    {
        return $this->hasOne(
            PostWoPlanOrder::class, 'post_id', 'id'
        );
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(PostWo::class);
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
