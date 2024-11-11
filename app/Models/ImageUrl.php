<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ImageUrl
 *
 * @property $id
 * @property $path
 * @property $url
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ImageUrl extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    public $incrementing = true;

    protected $primaryKey = 'id';

    protected $table = 'image_urls';

    protected $fillable = [
        'path', 'url', 'post_id'
    ];
    public $timestamps = true;

    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
