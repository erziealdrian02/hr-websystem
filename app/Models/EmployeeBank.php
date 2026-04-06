<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBank extends Model
{
    protected $table = 'employee_bank_accounts';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['employee_id', 'bank_name', 'bank_branch', 'account_number', 'account_holder_name', 'is_primary', 'created_by', 'updated_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
