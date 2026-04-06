<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'placements';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'client_location_id',
        'sk_number',
        'position_at_client',
        'start_date',
        'end_date',
        'placement_type',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'division_id', 'id');
    }
}
