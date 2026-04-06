<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'employee_number', 'full_name', 'profile_photo', 'job_title', 'division_id', 'manager_id', 'work_email', 'work_location', 'employment_status', 'join_date', 'contract_end_date', 'is_remote', 'gender', 'religion', 'place_of_birth', 'date_of_birth', 'marital_status', 'dependents_count', 'personal_email', 'phone_number', 'ktp_address', 'domicile_address', 'last_education', 'field_of_study', 'blood_type', 'nationality', 'created_by', 'updated_by'];

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
        return $this->hasMany(EmployeeEmergency::class, 'employee_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id', 'id');
    }

    public function payroll()
    {
        return $this->hasOne(EmployeePayroll::class, 'employee_id', 'id');
    }
}
