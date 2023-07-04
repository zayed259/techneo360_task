<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $month_array = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $last10YearsArray = range(date('Y'), date('Y') - 10);
        $years_array = array_combine($last10YearsArray, $last10YearsArray);

        return view('employee.report')->with(compact(['month_array', 'years_array']));
    }

    public function showReport(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        if($month){
            $from_date = $year.'-'.$month.'-01';    
            $to_date = $year.'-'.$month.'-'.date('t', strtotime($from_date));
        }else{
            $from_date = $request->from_date;
            $to_date = $request->to_date;
        }
        if($to_date >= date('Y-m-d')){
            $to_date = date('Y-m-d');
        }
        // print_r([$from_date, $to_date]); die;

        $employee_id = Auth::guard('employee')->user()->id;
         
        $condition = "";
        if ($year == '' && $month == '' && $from_date == '' && $to_date == '') {
            return response()->json(['status' => 'error', 'message' => 'Please select year and month, or from date and to date.']);
        }
        if ($year != '' && $month == '' && $from_date == '' && $to_date == '') {
            return response()->json(['status' => 'error', 'message' => 'Please select month']);
        }
        if ($year != '' && $month != '') {
            $condition = " and year(created_at) = '" . $year . "' and month(created_at) = '" . $month . "'";
        }
        if ($year == '' && $month != '' && $from_date == '' && $to_date == '') {
            return response()->json(['status' => 'error', 'message' => 'Please select year']);
        }
        if ($year == '' && $month == '' && $from_date != '' && $to_date == '') {
            return response()->json(['status' => 'error', 'message' => 'Please select to date']);
        }
        if ($year == '' && $month == '' && $from_date == '' && $to_date != '') {
            return response()->json(['status' => 'error', 'message' => 'Please select from date']);
        }

        if ($from_date != '' && $to_date != '') {
            $condition = " and date(created_at) between '" . $from_date . "' and '" . $to_date . "'";
        }

        $attendance = DB::select("SELECT id, employee_id, date(created_at) as date, created_at, updated_at from employee_attendances where employee_id = '" . $employee_id . "' " . $condition . " order by created_at desc");
        // echo "<pre>"; print_r($attendance); die;

        if (count($attendance) == 0) {
            return response()->json(['status' => 'error', 'message' => 'No data found.']);
        }

        $attendance_day = [];
        $period_attebdabce = CarbonPeriod::create($from_date, $to_date);
        foreach ($period_attebdabce as $date) {
          array_push($attendance_day, $date->format('Y-m-d'));
        }
        // print_r($attendance_day); die;

        $html = '<table class="table table-bordered border-primary table-hover text-center" id="" width="100%" cellspacing="0">
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
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';
        $total_late = 0;
        $total_present = 0;
        $total_absent = 0;
        $total_weekend = 0;
        foreach ($attendance_day as $key => $date) {
            $item = collect($attendance)->where('date', $date)->first();
            // print_r($item); die;
            $status = '';
            $bgColor = '';
            if($item){
                if (date('D', strtotime($item->created_at)) == 'Fri' || date('D', strtotime($item->created_at)) == 'Sat') {
                    $status = '<span class="badge badge-info">Weekend</span>';
                    $bgColor = 'bg-light';
                    $total_weekend++;
                } elseif (date('H:i', strtotime($item->created_at)) > '09:00') {
                    $status = '<span class="badge badge-warning">Late</span>';
                    $bgColor = '';
                    $total_late++;
                } else {
                    $status = '<span class="badge badge-success">Present</span>';
                    $bgColor = '';
                    $total_present++;
                }

                $html .= '<tr class="' . $bgColor . '">
                            <td>' . ($key + 1) . '</td>
                            <td>' . date('d-m-Y', strtotime($item->created_at ?? '')) . '</td>
                            <td>' . date('D', strtotime($item->created_at ?? '')) . '</td>
                            <td>9:00 AM</td>
                            <td>5:00 PM</td>
                            <td>' . date('h:i A', strtotime($item->created_at ?? '')) . '</td>
                            <td>' . date('h:i A', strtotime($item->updated_at ?? '')) . '</td>
                            <td> ' . (date('H:i', strtotime($item->created_at ?? '')) > '09:00' ? (strtotime(date('h:i A', strtotime($item->created_at ?? ''))) - strtotime('09:00 AM')) / 60 : 0) . ' </td>
                            <td>
                                ' . $status . '
                            </td>
                        </tr>';
            }
            else{
                if (date('D', strtotime($date)) == 'Fri' || date('D', strtotime($date)) == 'Sat') {
                    $status = '<span class="badge badge-info">Weekend</span>';
                    $bgColor = 'bg-light';
                    $total_weekend++;
                }
                else{
                    $status = '<span class="badge badge-danger">Absent</span>';
                    $bgColor = '';
                    $total_absent++;
                }
                $html .= '<tr class="' . $bgColor . '">
                            <td>' . ($key + 1) . '</td>
                            <td>' . date('d-m-Y', strtotime($date)) . '</td>
                            <td>' . date('D', strtotime($date)) . '</td>
                            <td>9:00 AM</td>
                            <td>5:00 PM</td>
                            <td>00:00</td>
                            <td>00:00</td>
                            <td>0</td>
                            <td>
                                ' . $status . '
                            </td>
                        </tr>';
            }
        }
        $html .= '<tr class="bg-primary text-white">
                    <td colspan="2" class="text-right">Total Present</td>
                    <td>' . $total_present . '</td>
                    <td colspan="2" class="text-right">Total Absent</td>
                    <td>' . $total_absent . '</td>
                    <td colspan="2" class="text-right">Total Weekend</td>
                    <td>' . $total_weekend . '</td>
                </tr>
                <tr class="bg-primary text-white">
                    <td colspan="2" class="text-right">Total Late</td>
                    <td>' . $total_late . '</td>
                    <td colspan="2" class="text-right">Total Days</td>
                    <td>' . count($attendance_day) . '</td>
                    <td colspan="2" class="text-right">Total Working Days</td>
                    <td>' . (count($attendance_day) - $total_weekend) . '</td>
                </tr>';
        $html .= '</tbody>
        </table>';

        return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully.', 'html' => $html]);
    }
}