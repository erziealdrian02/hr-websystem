<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeIndentities extends Model
{
    protected $table = 'employee_identities';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'nik_ktp',
        'bpjs_ketenagakerjaan',
        'bpjs_kesehatan',
        'passport_number',
        'passport_expiry',
        'tax_status_ptkp',
        'tax_method',
        'ktp_document_path',
        'npwp_document_path',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
