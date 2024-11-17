<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Class Order
 *
 * @property $id
 * @property $status
 * @property $path
 * @property $unit
 * @property $description
 * @property $req_qty
 * @property $rem_qty
 * @property $sch_qty
 * @property $uom
 * @property $required_date
 * @property $pick_up_from
 * @property $yard
 * @property $trip
 * @property $destination
 * @property $wr_number
 * @property $rig_name
 * @property $pic
 * @property $charge
 * @property $post_id
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PlanOrder extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $table = 'plan_orders';

    protected $fillable = [
        'status', 'description', 'req_qty', 'rem_qty', 'sch_qty', 'uom', 'required_date', 'pick_up_from', 'destination', 'wr_number', 'rig_name', 'pic', 'charge', 'post_id', 'yard', 'trip'
    ];
    function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    const ROUTE_POS = 2;

    const ROUTE_NAME = 'plan-orders';

    protected static function booted(): void
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
}
