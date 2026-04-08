<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'division_code',
        'name',
        'parent_id',
        'head_employee_id',
        'head_title',
        'cost_center',
        'description',
        'billing_type',
        'employee_count',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'division_id', 'id');
    }
}
