<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function bank()
    {
        return $this->hasOne(EmployeeBank::class, 'employee_id', 'id');
    }

    public function identity()
    {
        return $this->hasOne(EmployeeIndentities::class, 'employee_id', 'id');
    }

    public function emergency()
    {
        return $this->hasOne(EmployeeEmergency::class, 'employee_id', 'id');
    }
}
