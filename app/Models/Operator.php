<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Operator
 *
 * @property $id
 * @property $prefix
 * @property $postfix
 * @property $name
 * @property $short_name
 * @property $department_id
 *
 * RELATION
 * @property $department
 * @property $vehicles
 * @property $crews
 * @property $users
 *
 * @property $created_at
 * @property $updated_at
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Operator extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'prefix', 'postfix', 'name', 'short_name', 'department_id'
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(
            Post::class, 'id', 'post_id'
        );
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function crews(): HasMany
    {
        return $this->hasMany(Crew::class);
    }
    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
