<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ClientLocation extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'client_locations';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'client_name',
        'client_code',
        'industry',
        'pic_name',
        'pic_phone',
        'pic_email',
        'building_name',
        'address',
        'city',
        'province',
        'postal_code',
        'floor_unit',
        'latitude',
        'longitude',
        'attendance_radius_meter',
        'work_start_time',
        'work_end_time',
        'work_days',
        'is_active',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function placement()
    {
        return $this->hasMany(Placement::class, 'client_location_id', 'id');
    }

    public function division_client_location()
    {
        return $this->belongsTo(Division::class, 'client_location_id', 'id');
    }
}
