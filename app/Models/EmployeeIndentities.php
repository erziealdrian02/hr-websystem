<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeIndentities extends Model
{
    protected $table = 'employee_identities';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
