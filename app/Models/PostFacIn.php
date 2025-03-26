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
 * @property $well_name
 * @property $rig_name
 * @property $facility
 * @property $wbs_number
 * @property $type
 * @property $created_at
 *
 *  RELATION
 * @property $postFac
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostFacIn extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $perPage = 10;

    protected $table = 'post_fac_in';

    protected $fillable = [
        'well_name',
        'rig_name',
        'facility',
        'wbs_number',
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
