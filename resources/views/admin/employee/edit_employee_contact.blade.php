@extends('layouts.backend')

@section('pagetitle')
Update Employee Contact
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Update Employee Contact</h6>
            <a href="{{ route('admin.employee_contacts.show', $employee_id) }}" class="btn btn-sm btn-primary float-right ">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="card-body">
            @include('partial.flash')
            @include("partial.error")
            <form method="post" action="{{ route('admin.employee_contacts.update', $employee_contact->employee_id) }}">
                @method('PUT')
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" value="{{ $employee_contact->phone }}">
                        <input type="hidden" class="form-control" name="employee_id" id="employee_id" value="{{ $employee_id }}">
                    </div>
                    <div class="col-md-6">
                        <label for="office_phone">Office Phone</label>
                        <input type="text" class="form-control" name="office_phone" id="office_phone" placeholder="Your Office Phone" value="{{ $employee_contact->office_phone }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Your Email" value="{{ $employee_contact->email }}">
                    </div>
                    <div class="col-md-6">
                        <label for="optional_email">Optional Email</label>
                        <input type="text" class="form-control" name="optional_email" id="optional_email" placeholder="Your Optional Email" value="{{ $employee_contact->optional_email }}">
                    </div>
                </div>
                <fieldset class="border border-primary p-2 mb-2 rounded">
                    <legend class="h5 font-weight-bold">Emergency Contact</legend>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="emergency_name">Emergency Name</label>
                            <input type="text" class="form-control" name="emergency_name" id="emergency_name" placeholder="Your Emergency Name" value="{{ $employee_contact->emergency_name }}">
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_relation">Emergency Relation</label>
                            <input type="text" class="form-control" name="emergency_relation" id="emergency_relation" placeholder="Your Emergency Relation" value="{{ $employee_contact->emergency_relation }}">
                        </div>
                        <div class="col-md-4">
                            <label for="emergency_phone">Emergency Phone</label>
                            <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" placeholder="Your Emergency Phone" value="{{ $employee_contact->emergency_phone }}">
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="facebook">Facebook</label>
                        <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Ex: zayed259" value="{{ $employee_contact->facebook }}">
                    </div>
                    <div class="col-md-6">
                        <label for="twitter">Twitter</label>
                        <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Ex: zayed259" value="{{ $employee_contact->twitter }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="instagram">Instagram</label>
                        <input type="text" class="form-control" name="instagram" id="instagram" placeholder="Ex: zayed259" value="{{ $employee_contact->instagram }}">
                    </div>
                    <div class="col-md-6">
                        <label for="linkedin">Linkedin</label>
                        <input type="text" class="form-control" name="linkedin" id="linkedin" placeholder="Ex: zayed259" value="{{ $employee_contact->linkedin }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="whatsapp">Whatsapp</label>
                        <input type="text" class="form-control" name="whatsapp" id="whatsapp" placeholder="Enter your whatsapp number" value="{{ $employee_contact->whatsapp }}">
                    </div>
                    <div class="col-md-6">
                        <label for="website">Website</label>
                        <input type="text" class="form-control" name="website" id="website" placeholder="Ex: https://zayed.isdbstudents.com/" value="{{ $employee_contact->website }}">
                    </div>
                </div>

                <div class="form-group">
                    <input class="btn btn-primary btn-block" type="submit" value="Update Employee Contact">
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')

@endsection