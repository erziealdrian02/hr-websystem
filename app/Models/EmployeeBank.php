<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBank extends Model
{
    protected $table = 'employee_bank_accounts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
