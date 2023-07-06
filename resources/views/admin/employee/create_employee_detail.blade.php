@extends('layouts.backend')

@section('pagetitle')
Add Employee Details
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Add Employee Details</h6>
            <a href="{{ route('admin.employee_details.show', $employee_id) }}" class="btn btn-sm btn-primary float-right ">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="card-body">
            @include('partial.flash')
            @include("partial.error")
            <form method="post" action="{{ route('admin.employee_details.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="father_name">Father's Name</label>
                        <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name">
                        <input type="hidden" name="employee_id" value="{{ $employee_id }}">
                    </div>
                    <div class="col-md-6">
                        <label for="mother_name">Mother's Name</label>
                        <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother Name">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Address">
                    </div>
                    <div class="col-md-6">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control" name="photo" id="photo">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary">
                    </div>
                    <div class="col-md-6">
                        <label for="designation">Designation</label>
                        {!! designationsDropdown() !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="department">Department</label>
                        {!! departmentsDropdown() !!}
                    </div>
                    <div class="col-md-6">
                        <label for="joining_date">Joining Date</label>
                        <input type="date" class="form-control" name="joining_date" id="joining_date" placeholder="Joining Date">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="nid">NID</label>
                        <input type="text" class="form-control" name="nid" id="nid" placeholder="NID">
                    </div>
                    <div class="col-md-6">
                        <label for="bank_name">Bank Name</label>
                        {!! bankNamesDropdown() !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="bank_account">Bank Account</label>
                        <input type="text" class="form-control" name="bank_account" id="bank_account" placeholder="Bank Account">
                    </div>
                    <div class="col-md-6">
                        <label for="blood_group">Blood Group</label>
                        {!! bloodGroupsDropdown() !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-2">
                        <label for="marital_status">Marital Status</label>
                        {!! maritalStatusesDropdown() !!}
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary btn-block" type="submit" value="Add Employee Details">
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')

@endsection