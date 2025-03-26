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
 * @property $post_fac_id
 * @property $created_at
 *
 * RELATION
 * @property $postFac
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostFacOut extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'post_fac_out';

    protected $fillable = [
        'from_facility',
        'from_pit',
        'to_facility',
        'type',
        'post_fac_id',
    ];

    public function postFac(): BelongsTo
    {
        return $this->belongsTo(PostFac::class);
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
            return $model;
        });
    }
}
