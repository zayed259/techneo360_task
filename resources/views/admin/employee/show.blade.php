@extends('layouts.backend')

@section('pagetitle')
Employee Details
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Employee Details</h6>
            @if($employee_details == null)
            <a href="{{ route('admin.employee_details.create', $employee_id) }}" class="btn btn-sm btn-primary float-right ">
                <i class="fas fa-plus fa-sm text-white-50"></i>
                Add Employee Details
            </a>
            @else
            <a href="{{ route('admin.employee_details.edit', $employee_details->employee_id) }}" class="btn btn-sm btn-primary float-right ">
                <i class="fas fa-edit fa-sm text-white-50"></i>
                Edit Employee Details
            </a>
            @endif
        </div>
        @if($employee_details != null)
        <div class="card-body">
            <!-- table  -->
            <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover text-center" width="100%" cellspacing="0">
                    <tr>
                        <th>Employee ID</th>
                        <td>{{ $employee_details->employee->employee_id }}</td>

                        <th>Name</th>
                        <td>{{ $employee_details->employee->name }}</td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td>{{ $employee_details->father_name }}</td>

                        <th>Mother's Name</th>
                        <td>{{ $employee_details->mother_name }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $employee_details->address }}</td>

                        <th>Marital Status</th>
                        <td>
                            @if($employee_details->marital_status)
                            {{ $marital_status_array[$employee_details->marital_status] }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Salary</th>
                        <td>{{ $employee_details->salary }}</td>

                        <th>Designation</th>
                        <td>
                            @if($employee_details->designation)
                            {{ $designation_array[$employee_details->designation] }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>
                            @if($employee_details->department)
                            {{ $department_array[$employee_details->department] }}
                            @endif
                        </td>

                        <th>Joining Date</th>
                        <td>{{ $employee_details->joining_date }}</td>
                    </tr>
                    <tr>
                        <th>NID</th>
                        <td>{{ $employee_details->nid }}</td>

                        <th>Bank Name</th>
                        <td>
                            @if($employee_details->bank_name)
                            {{ $bank_name_array[$employee_details->bank_name] }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Bank Account</th>
                        <td>{{ $employee_details->bank_account }}</td>

                        <th>Blood Group</th>
                        <td>
                            @if($employee_details->blood_group)
                            {{ $blood_group_array[$employee_details->blood_group] }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Photo</th>
                        @if($employee_details->photo == null)
                        <td><img src="{{ asset('assets/img/avatars/avatar.jpg') }}" alt="Employee Photo" width="100px" height="100px"></td>
                        @else
                        <td><img src="{{ asset('images/employee/' . $employee_details->photo) }}" alt="Employee Photo" width="100px" height="100px"></td>
                        @endif
                        <th></th>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        @else
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-danger mb-4">Employee Details not Created</h1>
            </div>
        </div>
        @endif
    </div>
</div>


@endsection

@section('script')

@endsection