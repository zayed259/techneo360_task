<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDetail;
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
        $designation_array = [
            1 => 'CEO',
            2 => 'Manager',
            3 => 'Assistant Manager',
            4 => 'Senior Executive',
            5 => 'Executive',
            6 => 'Junior Executive',
            7 => 'Trainee',
            8 => 'Intern',
        ];

        $department_array = [
            1 => 'Management',
            2 => 'Marketing',
            3 => 'Sales',
            4 => 'Finance',
            5 => 'Human Resource',
            6 => 'Information Technology',
            7 => 'Customer Service',
            8 => 'Research and Development',
            9 => 'Production',
            10 => 'Logistics',
            11 => 'Procurement',
            12 => 'Legal',
            13 => 'Administration',
            14 => 'Security',
            15 => 'Other',
        ];
        
        $blood_group_array = [
            1 => 'A+',
            2 => 'A-',
            3 => 'B+',
            4 => 'B-',
            5 => 'O+',
            6 => 'O-',
            7 => 'AB+',
            8 => 'AB-',
        ];
        
        $marital_status_array = [
            1 => 'Married',
            2 => 'Unmarried',
            3 => 'Divorced',
            4 => 'Widowed',
            5 => 'Separated',
        ];
        $bank_name_array = [
            1 => 'Sonali Bank',
            2 => 'Janata Bank',
            3 => 'Agrani Bank',
            4 => 'Rupali Bank',
            6 => 'Islami Bank Bangladesh Limited',
            7 => 'Pubali Bank',
            8 => 'Dutch Bangla Bank Limited',
            9 => 'Brac Bank Limited',
            10 => 'Eastern Bank Limited',
            11 => 'Mercantile Bank Limited',
            12 => 'Mutual Trust Bank',
            13 => 'National Bank',
            14 => 'One Bank',
            15 => 'Premier Bank',
            16 => 'Prime Bank',
            17 => 'South East Bank',
            18 => 'Standard Bank',
            19 => 'Trust Bank',
            20 => 'United Commercial Bank',
            21 => 'IFIC Bank',
            22 => 'NRB Bank',
            23 => 'Bank Asia',
            24 => 'City Bank Limited',
            25 => 'Shahjalal Islami Bank',
            26 => 'Jamuna Bank',
            27 => 'NCC Bank',
            28 => 'NRB Commercial Bank',
            29 => 'Midland Bank',
            30 => 'Al-Arafah Islami Bank',
            31 => 'Modhumoti Bank',
            32 => 'NRB Global Bank',
            33 => 'NRB Bank',
            34 => 'NRB Commercial Bank'
        ];
        $employee_details = EmployeeDetail::where('employee_id', $id)->with('employee')->first();
        return view('admin.employee.show')->with(compact('employee_details'))->with('employee_id', $id)->with(compact(['designation_array', 'department_array', 'blood_group_array', 'marital_status_array', 'bank_name_array']));
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

    /**
     * Show the form for creating a new resource.
     */
    public function createEmployeeDetail(string $id)
    {
        $designation_array = [
            1 => 'CEO',
            2 => 'Manager',
            3 => 'Assistant Manager',
            4 => 'Senior Executive',
            5 => 'Executive',
            6 => 'Junior Executive',
            7 => 'Trainee',
            8 => 'Intern',
        ];

        $department_array = [
            1 => 'Management',
            2 => 'Marketing',
            3 => 'Sales',
            4 => 'Finance',
            5 => 'Human Resource',
            6 => 'Information Technology',
            7 => 'Customer Service',
            8 => 'Research and Development',
            9 => 'Production',
            10 => 'Logistics',
            11 => 'Procurement',
            12 => 'Legal',
            13 => 'Administration',
            14 => 'Security',
            15 => 'Other',
        ];
        
        $blood_group_array = [
            1 => 'A+',
            2 => 'A-',
            3 => 'B+',
            4 => 'B-',
            5 => 'O+',
            6 => 'O-',
            7 => 'AB+',
            8 => 'AB-',
        ];
        
        $marital_status_array = [
            1 => 'Married',
            2 => 'Unmarried',
            3 => 'Divorced',
            4 => 'Widowed',
            5 => 'Separated',
        ];
        $bank_name_array = [
            1 => 'Sonali Bank',
            2 => 'Janata Bank',
            3 => 'Agrani Bank',
            4 => 'Rupali Bank',
            6 => 'Islami Bank Bangladesh Limited',
            7 => 'Pubali Bank',
            8 => 'Dutch Bangla Bank Limited',
            9 => 'Brac Bank Limited',
            10 => 'Eastern Bank Limited',
            11 => 'Mercantile Bank Limited',
            12 => 'Mutual Trust Bank',
            13 => 'National Bank',
            14 => 'One Bank',
            15 => 'Premier Bank',
            16 => 'Prime Bank',
            17 => 'South East Bank',
            18 => 'Standard Bank',
            19 => 'Trust Bank',
            20 => 'United Commercial Bank',
            21 => 'IFIC Bank',
            22 => 'NRB Bank',
            23 => 'Bank Asia',
            24 => 'City Bank Limited',
            25 => 'Shahjalal Islami Bank',
            26 => 'Jamuna Bank',
            27 => 'NCC Bank',
            28 => 'NRB Commercial Bank',
            29 => 'Midland Bank',
            30 => 'Al-Arafah Islami Bank',
            31 => 'Modhumoti Bank',
            32 => 'NRB Global Bank',
            33 => 'NRB Bank',
            34 => 'NRB Commercial Bank'
        ];
        return view('admin.employee.create_employee_detail')->with('employee_id', $id)->with(compact(['designation_array', 'department_array', 'blood_group_array', 'marital_status_array', 'bank_name_array']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEmployeeDetail(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'employee_id' => 'required|string|max:255|unique:employee_details',
                'father_name' => 'nullable|string|max:255',
                'mother_name' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'salary' => 'nullable|numeric',
                'designation' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'joining_date' => 'nullable|date',
                'nid' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'bank_account' => 'nullable|string|max:255',
                'blood_group' => 'nullable|string|max:255',
                'marital_status' => 'nullable|string|max:255',
            ]
        );

        $employee_detail = new EmployeeDetail();
        $employee_detail->employee_id = $request->employee_id;
        $employee_detail->father_name = $request->father_name;
        $employee_detail->mother_name = $request->mother_name;
        $employee_detail->address = $request->address;
        $employee_detail->salary = $request->salary;
        $employee_detail->designation = $request->designation;
        $employee_detail->department = $request->department;
        $employee_detail->joining_date = $request->joining_date;
        $employee_detail->nid = $request->nid;
        $employee_detail->bank_name = $request->bank_name;
        $employee_detail->bank_account = $request->bank_account;
        $employee_detail->blood_group = $request->blood_group;
        $employee_detail->marital_status = $request->marital_status;
        $employee_detail->save();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = $request->employee_id . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/employee');
            $image->move($destinationPath, $name);
            $employee_detail->photo = $name;
            $employee_detail->save();
        }

        return redirect()->route('admin.employee_details.show', $request->employee_id)->with('message', 'Employee detail created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editEmployeeDetail(string $id)
    {
        $designation_array = [
            1 => 'CEO',
            2 => 'Manager',
            3 => 'Assistant Manager',
            4 => 'Senior Executive',
            5 => 'Executive',
            6 => 'Junior Executive',
            7 => 'Trainee',
            8 => 'Intern',
        ];

        $department_array = [
            1 => 'Management',
            2 => 'Marketing',
            3 => 'Sales',
            4 => 'Finance',
            5 => 'Human Resource',
            6 => 'Information Technology',
            7 => 'Customer Service',
            8 => 'Research and Development',
            9 => 'Production',
            10 => 'Logistics',
            11 => 'Procurement',
            12 => 'Legal',
            13 => 'Administration',
            14 => 'Security',
            15 => 'Other',
        ];
        
        $blood_group_array = [
            1 => 'A+',
            2 => 'A-',
            3 => 'B+',
            4 => 'B-',
            5 => 'O+',
            6 => 'O-',
            7 => 'AB+',
            8 => 'AB-',
        ];
        
        $marital_status_array = [
            1 => 'Married',
            2 => 'Unmarried',
            3 => 'Divorced',
            4 => 'Widowed',
            5 => 'Separated',
        ];

        $bank_name_array = [
            1 => 'Sonali Bank',
            2 => 'Janata Bank',
            3 => 'Agrani Bank',
            4 => 'Rupali Bank',
            6 => 'Islami Bank Bangladesh Limited',
            7 => 'Pubali Bank',
            8 => 'Dutch Bangla Bank Limited',
            9 => 'Brac Bank Limited',
            10 => 'Eastern Bank Limited',
            11 => 'Mercantile Bank Limited',
            12 => 'Mutual Trust Bank',
            13 => 'National Bank',
            14 => 'One Bank',
            15 => 'Premier Bank',
            16 => 'Prime Bank',
            17 => 'South East Bank',
            18 => 'Standard Bank',
            19 => 'Trust Bank',
            20 => 'United Commercial Bank',
            21 => 'IFIC Bank',
            22 => 'NRB Bank',
            23 => 'Bank Asia',
            24 => 'City Bank Limited',
            25 => 'Shahjalal Islami Bank',
            26 => 'Jamuna Bank',
            27 => 'NCC Bank',
            28 => 'NRB Commercial Bank',
            29 => 'Midland Bank',
            30 => 'Al-Arafah Islami Bank',
            31 => 'Modhumoti Bank',
            32 => 'NRB Global Bank',
            33 => 'NRB Bank',
            34 => 'NRB Commercial Bank'
        ];
        $employee_details = EmployeeDetail::where('employee_id', $id)->with('employee')->first();
        // dd($employee_details);
        return view('admin.employee.edit_employee_detail')->with(compact('employee_details'))->with(compact(['designation_array', 'department_array', 'blood_group_array', 'marital_status_array', 'bank_name_array']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeDetail(Request $request, string $id)
    {
        // dd($request->all());
        $request->validate(
            [
                'father_name' => 'nullable|string|max:255',
                'mother_name' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'salary' => 'nullable|string|max:255',
                'designation' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'joining_date' => 'nullable|date',
                'nid' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'bank_account' => 'nullable|string|max:255',
                'blood_group' => 'nullable|string|max:255',
                'marital_status' => 'nullable|string|max:255',
            ]
        );

        $employee_detail = EmployeeDetail::find($id);
        $employee_detail->father_name = $request->father_name;
        $employee_detail->mother_name = $request->mother_name;
        $employee_detail->address = $request->address;
        $employee_detail->salary = $request->salary;
        $employee_detail->designation = $request->designation;
        $employee_detail->department = $request->department;
        $employee_detail->joining_date = $request->joining_date;
        $employee_detail->nid = $request->nid;
        $employee_detail->bank_name = $request->bank_name;
        $employee_detail->bank_account = $request->bank_account;
        $employee_detail->blood_group = $request->blood_group;
        $employee_detail->marital_status = $request->marital_status;
        $employee_detail->save();

        $image_path = public_path("/images/employee/" . $employee_detail->photo);
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = $request->employee_id . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/employee');
            $image->move($destinationPath, $name);
            $employee_detail->photo = $name;
            $employee_detail->save();
        }

        return redirect()->route('admin.employee_details.show', $request->employee_id)->with('message', 'Employee detail updated successfully.');
    }
}
