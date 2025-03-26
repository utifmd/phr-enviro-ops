<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Team
 *
 * @property $id
 * @property $prefix
 * @property $postfix
 * @property $name
 * @property $short_name
 * @property $created_at
 * @property $updated_at
 *
 * @property $companies
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Team extends Model
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
    public function companies(): HasMany
    {
        return $this->hasMany(\App\Models\Company::class, 'id', 'company_id');
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
