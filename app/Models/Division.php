<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Division extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'divisions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'is_active' => 'boolean',
    ];
    protected $fillable = [
        'division_code',
        'name',
        'client_location_id',
        'head_employee_id',
        'head_title',
        'cost_center',
        'description',
        'billing_type',
        'employee_count',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'division_id', 'id');
    }

    public function manager_division()
    {
        return $this->belongsTo(Employee::class, 'head_employee_id', 'id');
    }

    public function division_client_location()
    {
        return $this->belongsTo(ClientLocation::class, 'client_location_id', 'id');
    }
}
