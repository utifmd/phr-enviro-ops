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
 * @property $highlight
 * @property $event
 * @property $area
 * @property $is_opened
 * @property $route_name
 * @property $url
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
    use HasUuids, HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $perPage = 10;

    protected $table = 'logs';

    protected $fillable = [
        'event', 'highlight', 'is_opened', 'area', 'route_name', 'url', 'user_id'
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
