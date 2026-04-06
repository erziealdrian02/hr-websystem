<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmergency extends Model
{
    protected $table = 'emergency_contacts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
