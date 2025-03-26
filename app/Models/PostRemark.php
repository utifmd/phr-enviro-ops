<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @property $id
 * @property $message
 * @property $post_id
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
class PostRemark extends Model
{
    use HasUuids;

    const PER_PAGE = 10;

    protected $keyType = 'string';

    protected $table = 'post_remarks';

    public $incrementing = false;

    protected $perPage = PostRemark::PER_PAGE;

    protected $fillable = [
        'message', 'post_id', 'user_id', 'created_at'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
