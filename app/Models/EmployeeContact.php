<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'phone',
        'emergency_name',
        'emergency_relation',
        'emergency_phone',
        'office_phone',
        'email',
        'optional_email',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'whatsapp',
        'website',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
