@extends('layouts.backend')

@section('pagetitle')
Attendance Report
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left mt-2">Attendance Report</h6>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="year">Year</label>
                    {!! years_dropdown($years_array) !!}
                </div>
                <div class="col-sm-3">
                    <label for="month">Month</label>
                    {!! months_dropdown($month_array) !!}
                </div>
                <div class="col-sm-2">
                    <label for="from_date">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control">
                </div>
                <div class="col-sm-2 mb-2">
                    <label for="to_date">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control">
                </div>
                <div class="col-sm-2">
                    <input type="reset" class="btn btn-danger btn-sm btn-block" value="Reset">
                    <a class="btn btn-sm btn-primary btn-profile btn-block" id="show">Show</a>
                </div>
            </div>
        </div>
        <hr class="m-0 p-0">
        <div class="card-body">
            <div class="table-responsive" id="showResults"></div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#show').on('click', function() {
            const year = $('#year').val();
            const month = $('#month').val();
            const from_date = $('#from_date').val();
            const to_date = $('#to_date').val();
            $.ajax({
                url: "{{ route('employee.report.show') }}",
                type: "POST",
                data: {
                    year,
                    month,
                    from_date,
                    to_date,
                },
                beforeSend: function() {
                    $('#showResults').html('<h1 class="text-center"><i class="fas fa-spinner fa-spin"></i></h1>');
                },
                success: function(data) {
                    // alert('success');
                    if (data.status == 'error') {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#showResults').html('');
                    }
                    if (data.status == 'success') {
                        $('#showResults').html(data.html);
                    }
                },
                error: function(error) {
                    // alert('error');
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });

        // search panel enable disable
        $('#month').attr('disabled', true);
        $('#year').on('change', function() {
            if ($(this).val() != '') {
                $('#month').attr('disabled', false);
                $('#from_date').attr('disabled', true);
            } else {
                $('#month').attr('disabled', true);
                $('#from_date').attr('disabled', false);
            }
        });
        $('#to_date').attr('disabled', true);
        $('#from_date').on('change', function() {
            if ($(this).val() != '') {
                $('#year').attr('disabled', true);
                $('#to_date').attr('disabled', false);
            } else {
                $('#year').attr('disabled', false);
                $('#to_date').attr('disabled', true);
            }
        });
    });
</script>
@endsection