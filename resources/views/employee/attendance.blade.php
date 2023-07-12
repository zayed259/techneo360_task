@extends('layouts.backend')

@section('pagetitle')
Attendance List
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left mt-2 attendanceList">Attendance List</h6>
            <div class="float-right d-flex">
                <h6 class="m-0 font-weight-bold text-primary mr-3 mt-2 attendanceHere">
                    Attendence Here
                    <i class="fas fa-hand-point-right"></i>
                </h6>
                <div class="progress mb-2 mr-2">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <button class="btn btn-primary btn-sm" title="Press and hold 3 seconds" id="attendanceButton"><i class="fas fa-fingerprint"></i></button>
                <input type="hidden" name="employee_id" value="{{ Auth::guard('employee')->user()->id }}" id="employee_id">
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive" id="showAllRecords">
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    $(document).ready(function() {
        var buttonPressTimer;
        $('#attendanceButton').on('mousedown touchstart', function() {
            buttonPressTimer = setTimeout(submitForm, 3000);
            $('.progress-bar').css('width', '100%');
        }).on('mouseup touchend', function() {
            clearTimeout(buttonPressTimer);
            $('.progress-bar').css('width', '0%');
        });

        function submitForm() {
            const employee_id = $('#employee_id').val();
            $.ajax({
                url: "{{ route('employee.attendance.store') }}",
                type: "POST",
                data: {
                    employee_id: employee_id,
                },
                dataType: "JSON",
                beforeSend: function() {
                    $('#attendanceButton').html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('#attendanceButton').html('<i class="fas fa-fingerprint"></i>');
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    if (response.status == 'error') {
                        $('#attendanceButton').html('<i class="fas fa-fingerprint"></i>');
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    $('.progress-bar').css('width', '0%');
                    showAllRecords();
                },
                error: function(response) {
                    $('#attendanceButton').html('<i class="fas fa-fingerprint"></i>');
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Something went wrong!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.progress-bar').css('width', '0%');
                }
            });
        }

        //showAllRecords
        showAllRecords();

        function showAllRecords() {
            $.ajax({
                url: "{{ route('employee.attendance.show') }}",
                type: 'GET',
                data: {
                    show: 1
                },
                dataType: 'JSON',
                success: function(response) {
                    $('#showAllRecords').html(response.html);
                }
            });
        }
    });
</script>
@endsection