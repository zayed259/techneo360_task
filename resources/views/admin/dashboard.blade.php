@extends('layouts.backend')

@section('pagetitle')
    Admin Dashboard
@endsection

@section('content')
<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between border-left-info">
        <h6 class="m-0 font-weight-bold text-primary">Admin Dashboard</h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                aria-labelledby="dropdownMenuLink">
                <div class="dropdown-header">Select Option:</div>
                <a class="dropdown-item" href="{{url('contact/create')}}"><i class="far fa-plus-square fa-sm fa-fw mr-1"></i>Add Contact</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('contact/trashed')}}"><i class="fas fa-trash-alt fa-sm fa-fw mr-1"></i>Trashed Contact</a>
                <a class="dropdown-item" href="{{url('export_contact_pdf')}}"><i class="fas fa-file-pdf fa-sm fa-fw mr-1"></i>Export PDF</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    
@endsection