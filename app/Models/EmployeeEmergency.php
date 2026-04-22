<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmergency extends Model
{
    protected $table = 'emergency_contacts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'contact_name',
        'relationship',
        'phone_number',
        'is_primary',
        'address',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
