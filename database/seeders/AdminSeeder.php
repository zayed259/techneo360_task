<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::where('email', 'admin@gmail.com')->first();
        if (is_null($admin)) {
            Admin::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
            ]);
        }

        // $employee = Employee::where('email', 'employee@gmail.com')->first();
        // if (is_null($employee)) {
        //     Employee::create([
        //         'employee_id' => '122167',
        //         'name' => 'Employee',
        //         'email' => 'employee@gmail.com',
        //         'password' => Hash::make('employee123'),
        //     ]);
        // }
    }
}
