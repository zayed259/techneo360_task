@extends('layouts.backend')

@section('pagetitle')
Edit Employee Details
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Update Employee Details</h6>
            <a href="{{ route('admin.employee_details.show', $employee_details->employee_id) }}" class="btn btn-sm btn-primary float-right ">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="card-body">
            @include('partial.flash')
            @include("partial.error")
            <form method="post" action="{{ route('admin.employee_details.update', $employee_details->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="father_name">Father's Name</label>
                        <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name" value="{{ $employee_details->father_name }}">
                        <input type="hidden" name="employee_id" value="{{ $employee_details->employee_id }}">
                    </div>
                    <div class="col-md-6">
                        <label for="mother_name">Mother's Name</label>
                        <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother Name" value="{{ $employee_details->mother_name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{ $employee_details->address }}">
                    </div>
                    <div class="col-md-6">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control" name="photo" id="photo">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" value="{{ $employee_details->salary }}">
                    </div>
                    <div class="col-md-6">
                        <label for="designation">Designation</label>
                        {!! designations_dropdown($designation_array, $employee_details->designation) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="department">Department</label>
                        {!! departments_dropdown($department_array, $employee_details->department) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="joining_date">Joining Date</label>
                        <input type="date" class="form-control" name="joining_date" id="joining_date" placeholder="Joining Date" value="{{ $employee_details->joining_date }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="nid">NID</label>
                        <input type="text" class="form-control" name="nid" id="nid" placeholder="NID" value="{{ $employee_details->nid }}">
                    </div>
                    <div class="col-md-6">
                        <label for="bank_name">Bank Name</label>
                        {!! bank_names_dropdown($bank_name_array, $employee_details->bank_name) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="bank_account">Bank Account</label>
                        <input type="text" class="form-control" name="bank_account" id="bank_account" placeholder="Bank Account" value="{{ $employee_details->bank_account }}">
                    </div>
                    <div class="col-md-6">
                        <label for="blood_group">Blood Group</label>
                        {!! blood_groups_dropdown($blood_group_array, $employee_details->blood_group) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="marital_status">Marital Status</label>
                        {!! marital_statuses_dropdown($marital_status_array, $employee_details->marital_status) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="photo" class="mr-4">Photo</label>
                        @if($employee_details->photo == null)
                        <img src="{{ asset('assets/img/avatars/avatar.jpg') }}" alt="Employee Photo" width="100px" height="100px">
                        @else
                        <img src="{{ asset('images/employee/' . $employee_details->photo) }}" alt="Employee Photo" width="100px" height="100px">
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary btn-block" type="submit" value="Update Employee Details">
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')

@endsection