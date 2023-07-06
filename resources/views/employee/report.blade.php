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
            <form id="reportForm">
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="searchOption">Search Option</label>
                        {!! searchOptionDropdown() !!}
                    </div>
                    <div class="col-sm-3 hide" id="yearDiv">
                        <label for="year">Year</label>
                        {!! yearsDropdown() !!}
                    </div>
                    <div class="col-sm-3 hide" id="monthDiv">
                        <label for="month">Month</label>
                        {!! monthsDropdown() !!}
                    </div>
                    <div class="col-sm-3 hide" id="fromDateDiv">
                        <label for="from_date">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>
                    <div class="col-sm-3 mb-2 hide" id="toDateDiv">
                        <label for="to_date">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>
                    <div class="col-sm-3 hide" id="searchDiv">
                        <input type="reset" class="btn btn-danger btn-sm btn-block" value="Reset" id="resetBtn">
                        <a class="btn btn-sm btn-primary btn-profile btn-block" id="show">Show</a>
                    </div>
                </div>
            </form>
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
        // show attendance
        $('#show').on('click', function() {
            const searchOption = $('#searchOption').val();
            const year = $('#year').val();
            const month = $('#month').val();
            const from_date = $('#from_date').val();
            const to_date = $('#to_date').val();
            $.ajax({
                url: "{{ route('employee.report.show') }}",
                type: "POST",
                data: {
                    searchOption,
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

        // search option change event
        $('#searchOption').on('change', function() {
            const searchOption = $(this).val();
            if (searchOption == 1) {
                $('#yearDiv').show();
                $('#monthDiv').show();
                $('#from_date').val('');
                $('#to_date').val('');
                $('#month').attr('disabled', true);
                $('#to_date').attr('disabled', true);
                $('#fromDateDiv').hide();
                $('#toDateDiv').hide();
                $('#searchDiv').show();
            } else if (searchOption == 2) {
                $('#yearDiv').hide();
                $('#monthDiv').hide();
                $('#year').val('');
                $('#month').val('');
                $('#month').attr('disabled', true);
                $('#to_date').attr('disabled', true);
                $('#fromDateDiv').show();
                $('#toDateDiv').show();
                $('#searchDiv').show();
            } else {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#year').val('');
                $('#month').val('');
                $('#month').attr('disabled', true);
                $('#to_date').attr('disabled', true);
                $('#yearDiv').hide();
                $('#monthDiv').hide();
                $('#fromDateDiv').hide();
                $('#toDateDiv').hide();
                $('#searchDiv').hide();
                $('#showResults').html('');
            }
        });

        //year change event
        $('#month').attr('disabled', true);
        $('#year').on('change', function() {
            const year = $(this).val();
            if (year != '') {
                $('#month').attr('disabled', false);
            } else {
                $('#month').attr('disabled', true);
                $('#month').val('');
            }
        });

        //from date change event
        $('#to_date').attr('disabled', true);
        $('#from_date').on('change', function() {
            const from_date = $(this).val();
            if (from_date != '') {
                $('#to_date').attr('disabled', false);
            } else {
                $('#to_date').attr('disabled', true);
                $('#to_date').val('');
            }
        });

        //reset button click event
        $('#resetBtn').on('click', function() {
            $('#searchOption').val('');
            $('#year').val('');
            $('#month').val('');
            $('#from_date').val('');
            $('#to_date').val('');
            $('#month').attr('disabled', true);
            $('#to_date').attr('disabled', true);
            $('#yearDiv').hide();
            $('#monthDiv').hide();
            $('#fromDateDiv').hide();
            $('#toDateDiv').hide();
            $('#searchDiv').hide();
            $('#showResults').html('');
        });
    });
</script>
@endsection