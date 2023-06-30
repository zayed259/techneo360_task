@extends('layouts.backend')

@section('pagetitle')
Employee Contact
@endsection

@section('content')
<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary float-left">Employee Contact</h6>
        @if($employee_contact == null)
        <a href="{{ route('admin.employee_contacts.create', $employee_id) }}" class="btn btn-sm btn-primary float-right ">Add Employee Contact</a>
        @else
        <a href="{{ route('admin.employee_contacts.edit', $employee_contact->employee_id) }}" class="btn btn-sm btn-primary float-right ">Edit Employee Contact</a>
        @endif
    </div>
    @if($employee_contact != null)
    <!-- Card Body -->
    <div class="card-body p-0 m-0">
        <div class="contact-details">
            <div class="contact-photo">
                @if ($employee_contact->photo)
                <img src="{{ asset('images/employee/' . $employee_contact->employee_detail->photo) }}" alt="Employee Photo" width="100px" height="100px">
                @else
                <img src="{{url('assets/img/avatars/avatar.jpg')}}" alt="image">
                @endif
            </div>
            <div class="name-contact">
                <h1> {{ $employee_contact->employee->name }}</h1>
                <p>{{ $employee_contact->phone }}</p>
            </div>
            <div class="icons text-center">
                @if ($employee_contact->email)
                <a href="mailto:{{$employee_contact->email}}" class="btn btn-primary btn-circle me-1" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
                @endif
                @if ($employee_contact->phone)
                <a href="tel:{{$employee_contact->phone}}" class="btn btn-primary btn-circle me-1" title="Call">
                    <i class="fas fa-phone"></i>
                </a>
                @endif
                @if ($employee_contact->whatsapp)
                <a href="https://api.whatsapp.com/send?phone={{$employee_contact->whatsapp}}" class="btn btn-primary btn-circle me-1" title="Whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                @endif
                @if ($employee_contact->facebook)
                <a href="https://www.facebook.com/{{$employee_contact->facebook}}" target="_blank" class="btn btn-primary btn-circle me-1" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                @endif
                @if ($employee_contact->instagram)
                <a href="https://www.instagram.com/{{$employee_contact->instagram}}" target="_blank" class="btn btn-primary btn-circle me-1" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                @endif
                @if ($employee_contact->twitter)
                <a href="https://twitter.com/{{$employee_contact->twitter}}" target="_blank" class="btn btn-primary btn-circle me-1" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                @endif
                @if ($employee_contact->linkedin)
                <a href="https://www.linkedin.com/in/{{$employee_contact->linkedin}}" target="_blank" class="btn btn-primary btn-circle me-1" title="Linkedin">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                @endif
            </div>
        </div>

        <div class="contact-info">
            <div>
                <h1>Phone</h1>
                <p>{{ $employee_contact->phone }}</p>
            </div>
            <div>
                <a href="tel:{{$employee_contact->phone}}" class="btn btn-primary btn-circle" title="Call">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </div>
        <hr class="contact-ruller">
        @if ($employee_contact->office_phone)
        <div class="contact-info">
            <div>
                <h1>Office Phone</h1>
                <p>{{ $employee_contact->office_phone }}</p>
            </div>
            <div>
                <a href="tel:{{$employee_contact->office_phone}}" class="btn btn-primary btn-circle" title="Call">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </div>
        <hr class="contact-ruller">
        @endif
        @if ($employee_contact->emergency_phone)
        <div class="contact-info">
            <div>
                <h1>Emergency Phone</h1>
                <p>{{ $employee_contact->emergency_name }} ({{$employee_contact->emergency_relation}}) </p>
                <p>{{ $employee_contact->emergency_phone }}</p>
            </div>
            <div>
                <a href="tel:{{$employee_contact->emergency_phone}}" class="btn btn-primary btn-circle" title="Call">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
        </div>
        <hr class="contact-ruller">
        @endif
        @if ($employee_contact->email)
        <div class="contact-info">
            <div>
                <h1>Email</h1>
                <p>{{ $employee_contact->email }}</p>
            </div>
            <div>
                <a href="mailto:{{$employee_contact->email}}" class="btn btn-primary btn-circle" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
        <hr class="contact-ruller">
        @endif
        @if ($employee_contact->optional_email)
        <div class="contact-info">
            <div>
                <h1>Optional Email</h1>
                <p>{{ $employee_contact->optional_email }}</p>
            </div>
            <div>
                <a href="mailto:{{$employee_contact->optional_email}}" class="btn btn-primary btn-circle" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>
        <hr class="contact-ruller">
        @endif
        @if ($employee_contact->website)
        <div class="contact-info">
            <div>
                <h1>Website</h1>
                <p>{{ $employee_contact->website }}</p>
            </div>
            <div>
                <a href="{{$employee_contact->website}}" target="_blank" class="btn btn-primary btn-circle" title="Website">
                    <i class="fas fa-globe"></i>
                </a>
            </div>
        </div>
        <hr class="contact-ruller">
        @endif
        @if ($employee_contact->address)
        <div class="contact-info">
            <div>
                <h1>Address</h1>
                <p>{{ $employee_contact->address }}</p>
            </div>
            <div>
                <a href="https://www.google.com/maps/search/?api=1&query={{$employee_contact->address}}" target="_blank" class="btn btn-primary btn-circle" title="Address">
                    <i class="fas fa-map-marker-alt"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
    @else
    <div class="card-body">
        <div class="text-center">
            <h1 class="h4 text-danger mb-4">Employee Contact Not Found!</h1>
        </div>
    </div>
    @endif
</div>
@endsection