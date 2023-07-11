<table class="table table-bordered border-primary table-hover text-center" id="dataTable" width="100%" cellspacing="0">
    <thead class="bg-primary text-white">
        <tr>
            <th>#</th>
            <th>Employee Name</th>
            <th>Total Late</th>
            <th>Total Early Out</th>
            <th>Total (Late+Early Out)</th>
            <th>Total Absent</th>
            <th>Total Present</th>
            <th>Total Weekend</th>
            <th>Total Working Days</th>
            <th>Total Days</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($query as $val)
        <tr>
            <td> {{ $loop->iteration }} </td>
            <td> {{ $val->name }} </td>
            <td> {{ $val->total_late }} </td>
            <td> {{ $val->total_early_out }} </td>
            <!-- <td> {{ $val->total_late + $val->total_early_out }} </td> -->
            <!-- if total late + total early out more than 3 days then background color is red  -->
            @if ($val->total_late + $val->total_early_out > 3)
            <td class="bg-danger text-white"> {{ $val->total_late + $val->total_early_out }} </td>
            @else
            <td> {{ $val->total_late + $val->total_early_out }} </td>
            @endif
            <td> {{ $workingDay - $val->total_attendance }} </td>
            <td> {{ $val->total_attendance }} </td>
            <td> {{ $countWeekend }} </td>
            <td> {{ $workingDay }} </td>
            <td> {{ $totalDay }} </td>
        </tr>
        @endforeach
    </tbody>
</table>