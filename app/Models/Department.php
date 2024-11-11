<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Department
 *
 * @property $id
 * @property $prefix
 * @property $postfix
 * @property $name
 * @property $short_name
 * @property $created_at
 * @property $updated_at
 *
 * @property $operators
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Department extends Model
{
    use HasFactory, HasUuids;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['prefix', 'postfix', 'name', 'short_name'];

    public $incrementing = false;

    protected $keyType = 'string';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operators(): HasMany
    {
        return $this->hasMany(\App\Models\Operator::class, 'id', 'department_id');
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
