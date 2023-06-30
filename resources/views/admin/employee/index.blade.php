@extends('layouts.backend')

@section('pagetitle')
Employee List
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Employee List</h6>
            <!-- add employee -->
            <a href="{{ route('admin.employee.create') }}" class="btn btn-sm btn-primary float-right ">Add Employee</a>
        </div>
        <div class="card-body">
            <!-- table  -->
            <div class="table-responsive">
                <table class="table table-bordered border-primary table-hover text-center" id="dataTable" width="100%" cellspacing="0">
                    <!-- table head -->
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>#</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- table head -->
                    <!-- table body -->
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @if ($employee->status == 1)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <!-- dropdown -->
                            <td>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="employeeDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="employeeDropdownMenu">
                                        <a class="dropdown-item" href="{{ route('admin.employee.edit', $employee->id) }}">
                                            <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item" href="{{ route('admin.employee_details.show', $employee->id) }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Details
                                        </a>
                                        <a class="dropdown-item" href="">
                                            <i class="fas fa-phone fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Contact
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!-- table body -->
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

@endsection