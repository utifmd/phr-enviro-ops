<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $username
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $role
 * @property $area_name
 * @property $operator_id
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * RELATION
 * @property $currentPost
 * @property $operator
 * @property $posts
 * @property $workTrips
 * @property $workTripNotes
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'role',
        'area_name',
        'operator_id',
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function operator(): HasOne
    {
        return $this->hasOne(
            Operator::class, 'id', 'operator_id'
        );
    }

    public function currentPost(): HasOne
    {
        return $this->hasOne(
            UserCurrentPost::class, 'user_id', 'id'

        )->where('steps', '=', -1);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(
            Post::class, 'user_id', 'id'
        );
    }

    public function workTripInfos(): HasMany
    {
        return $this->hasMany(
            WorkTripInfo::class, 'user_id', 'id'
        );
    }
    public function workTripNotes(): HasMany
    {
        return $this->hasMany(
            WorkTripNote::class, 'user_id', 'id'
        );
    }

    public function logs(): HasMany
    {
        return $this->hasMany(
            Log::class, 'user_id', 'id'
        );
    }

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    
}
