<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = 'payrolls';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'period_year',
        'period_month',
        'basic_salary',
        'allowance_total',
        'overtime_pay',
        'bonus',
        'gross_pay',
        'deduction_pph21',
        'deduction_bpjs_kes',
        'deduction_bpjs_jht',
        'deduction_bpjs_jp',
        'deduction_other',
        'total_deductions',
        'net_pay',
        'transfer_date',
        'status',
        'notes',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
