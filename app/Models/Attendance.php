<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'user_id',
        'attendance_date',
        'clock_in',
        'clock_out',
        'working_minutes',
        'status',
        'location_note',
        'ip_address',
        'notes',
        'created_by',
        'updated_by'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function corrections()
    {
        return $this->hasMany(AttendanceCorrection::class, 'attendance_id', 'id');
    }
}
