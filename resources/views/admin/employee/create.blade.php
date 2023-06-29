@extends('layouts.backend')

@section('pagetitle')
Add Employee
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Add Employee</h6>
            <a href="{{ route('admin.employee') }}" class="btn btn-sm btn-primary float-right ">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="card-body">
            @include('partial.flash')
            @include("partial.error")
            <form method="post" action="{{ route('admin.employee.store') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Your Email">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 pb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary btn-block" type="submit" value="Add Employee">
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')

@endsection