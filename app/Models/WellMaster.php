<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class WorkOrder
 *
 * @property $id
 * @property $field_name
 * @property $ids_wellname
 * @property $well_number
 * @property $legal_well
 * @property $job_type
 * @property $job_sub_type
 * @property $rig_type
 * @property $rig_no
 * @property $wbs_number
 * @property $actual_drmi
 * @property $actual_spud
 * @property $actual_drmo
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class WellMaster extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $perPage = 10;

    public $fillable = [
        'field_name', 'ids_wellname', 'well_number', 'legal_well', 'job_type', 'job_sub_type', 'rig_type', 'rig_no', 'wbs_number', 'actual_drmi', 'actual_spud', 'actual_drmo', 'status'
    ];

    protected static function booted(): void
    {
        self::creating(function ($table) {
            $table->id = Str::uuid();
        });
    }
    public const WELL_MASTER_NAME = "WELL_MASTER_SESSION";
}
