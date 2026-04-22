<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AttendanceCorrection extends Model
{
    use HasUuids;

    protected $table = 'attendance_corrections';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'attendance_id',
        'corrected_clock_in',
        'corrected_clock_out',
        'reason',
        'proof_file_path',
        'status',
        'created_by',
        'updated_by'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }
}
