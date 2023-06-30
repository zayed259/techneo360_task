<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'father_name',
        'mother_name',
        'address',
        'photo',
        'salary',
        'joining_date',
        'nid',
        'bank_name',
        'bank_account',
        'blood_group',
        'marital_status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
