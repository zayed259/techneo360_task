<table class="table table-bordered border-primary table-hover text-center" id="" width="100%" cellspacing="0">
    <thead class="bg-primary text-white">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Day</th>
            <th>In Time</th>
            <th>Out Time</th>
            <th>Actual In</th>
            <th>Actual Out</th>
            <th>Late</th>
            <th>Early Out</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_late = $total_present = $total_absent = $total_weekend = $total_early_out = 0;
        @endphp
        @foreach ($attendance_day as $key => $date)
            @php
                $status = "";
                $status_2 = "";
                $bgColor = "";
                $item = collect($attendance)->where('date', $date)->first();
            @endphp
        @if ($item)
            @if (date('D', strtotime($item->created_at)) == 'Fri' || date('D', strtotime($item->created_at)) == 'Sat')
                @php
                    $status = '<span class="badge badge-info">Weekend</span>';
                    $bgColor = 'bg-light';
                    $total_weekend++;
                @endphp
            @elseif (date('H:i', strtotime($item->created_at)) > '09:00' || date('H:i', strtotime($item->updated_at)) < '17:00' )
                @if (date('H:i', strtotime($item->created_at)) > '09:00')
                    @php
                        $status = '<span class="badge badge-warning">Late</span>';
                        $bgColor = '';
                        $total_late++;
                    @endphp
                @endif
                @if (date('H:i', strtotime($item->updated_at)) < '17:00' )
                    @php 
                        $status_2='<span class="badge badge-warning">Early Out</span>' ; 
                        $bgColor='' ; 
                        $total_early_out++; 
                    @endphp
                @endif 
            @else 
                @php 
                    $status='<span class="badge badge-success">Present</span>' ; 
                    $bgColor='' ; 
                    $total_present++; 
                @endphp 
            @endif 
            <tr class="{{ $bgColor }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                <td>{{ date('D', strtotime($item->created_at)) }}</td>
                <td>9:00 AM</td>
                <td>5:00 PM</td>
                <td>{{ date('h:i A', strtotime($item->created_at )) }}</td>
                <td>{{ date('h:i A', strtotime($item->updated_at )) }}</td>
                <td>
                    {{ (date('H:i', strtotime($item->created_at )) > '09:00' ? (strtotime(date('h:i A', strtotime($item->created_at))) - strtotime('09:00 AM')) / 60 : 0) }}
                </td>
                <td>
                    {{ (date('H:i', strtotime($item->updated_at)) < '17:00' ? (strtotime('05:00 PM') - strtotime(date('h:i A', strtotime($item->updated_at)))) / 60 : 0) }}
                </td>
                <td>
                    {!! $status !!} {!! $status_2 !!}
                </td>
            </tr>
        @else
            @if (date('D', strtotime($date)) == 'Fri' || date('D', strtotime($date)) == 'Sat')
                @php
                    $status = '<span class="badge badge-info">Weekend</span>';
                    $bgColor = 'bg-light';
                    $total_weekend++;
                @endphp
            @else
                @php
                    $status = '<span class="badge badge-danger">Absent</span>';
                    $bgColor = '';
                    $total_absent++;
                @endphp
            @endif
            <tr class="{{ $bgColor }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d-m-Y', strtotime($date)) }}</td>
                <td>{{ date('D', strtotime($date)) }}</td>
                <td>9:00 AM</td>
                <td>5:00 PM</td>
                <td>00:00</td>
                <td>00:00</td>
                <td>0</td>
                <td>0</td>
                <td>
                    {!! $status !!} {!! $status_2 !!}
                </td>
            </tr>
        @endif
        @endforeach
    </tbody>
</table>

<table class="table table-bordered border-primary table-hover text-center" id="" width="100%" cellspacing="0">
    <tr class="bg-primary text-white">
        <td class="text-right">Total Present</td>
        <td> {{ $total_present }} </td>
        <td class="text-right">Total Absent</td>
        <td> {{ $total_absent }} </td>
        <td class="text-right">Total Weekend</td>
        <td> {{ $total_weekend }} </td>
        <td class="text-right">Total Late</td>
        <td> {{ $total_late }} </td>
    </tr>
    <tr class="bg-primary text-white">
        <td class="text-right">Total Early Out</td>
        <td> {{ $total_early_out }} </td>
        <td class="text-right">Total Days</td>
        <td> {{ count($attendance_day) }} </td>
        <td class="text-right">Total Working Days</td>
        <td> {{ count($attendance_day) - $total_weekend }} </td>
        <td class="text-right">Total Working Hours</td>
        <td> {{ (count($attendance_day) - $total_weekend) * 8 }} </td>
    </tr>
</table>