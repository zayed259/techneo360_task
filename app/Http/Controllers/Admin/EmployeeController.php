<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:employees',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|string|min:8|same:password'
            ]
        );

        $employee = Employee::where('email', $request->email)->first();
        if (is_null($employee)) {
            $employee = new Employee();
            $employee->employee_id = rand(100000, 999999);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $employee->save();
        }

        return redirect()->route('admin.employee')->with('message', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);
        return view('admin.employee.edit')->with(compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'employee_id' => 'required|string|max:255|unique:employees,employee_id,' . $id,
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:employees,email,' . $id,
                'status' => 'required|boolean',
                'password' => 'nullable|string|min:8',
                'password_confirmation' => 'nullable|string|min:8|same:password'
            ]
        );

        $employee = Employee::find($id);
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->email = $request->email;
        if (!empty($request->password)) {
            $employee->password = Hash::make($request->password);
        }
        $employee->status = $request->status;
        $employee->save();

        return redirect()->route('admin.employee')->with('message', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
