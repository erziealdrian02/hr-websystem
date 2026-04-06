<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    use HasFactory;

    protected $table = 'placements';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
