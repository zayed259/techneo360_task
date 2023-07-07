<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report');
    }

    public function showReport(Request $request)
    {
        $searchOption = $request->searchOption;
        $year = $request->year;
        $month = $request->month;
        if ($month) {
            $from_date = $year . '-' . $month . '-01';
            $to_date = $year . '-' . $month . '-' . date('t', strtotime($from_date));
        } else {
            $from_date = $request->from_date;
            $to_date = $request->to_date;
        }
        if ($to_date >= date('Y-m-d')) {
            $to_date = date('Y-m-d');
        }
        // print_r([$from_date, $to_date]); die;

        // $employee_id = Auth::guard('employee')->user()->id;

        $condition = "";
        if ($searchOption == 1) {
            if ($year == '' && $month == '') {
                return response()->json(['status' => 'error', 'message' => 'Please select year and month.']);
            }
            if ($year != '' && $month == '') {
                return response()->json(['status' => 'error', 'message' => 'Please select month']);
            }
            if ($year == '' && $month != '') {
                return response()->json(['status' => 'error', 'message' => 'Please select year']);
            }
            if ($year != '' && $month != '') {
                $condition = " and year(ea.created_at) = '" . $year . "' and month(ea.created_at) = '" . $month . "'";
            }
        } elseif ($searchOption == 2) {
            if ($from_date == '' && $to_date == '') {
                return response()->json(['status' => 'error', 'message' => 'Please select from date and to date.']);
            }
            if ($from_date != '' && $to_date == '') {
                return response()->json(['status' => 'error', 'message' => 'Please select to date']);
            }
            if ($from_date == '' && $to_date != '') {
                return response()->json(['status' => 'error', 'message' => 'Please select from date']);
            }
            if ($from_date != '' && $to_date != '') {
                $condition = " and date(ea.created_at) between '" . $from_date . "' and '" . $to_date . "'";
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Please select search option.']);
        }

        $attendance_day = [];
        $period_attebdabce = CarbonPeriod::create($from_date, $to_date);
        foreach ($period_attebdabce as $date) {
            array_push($attendance_day, $date->format('Y-m-d'));
        }
        // print_r($attendance_day); die;

        // $attendance = DB::select("SELECT ea.id, ea.employee_id, date(ea.created_at) as date, ea.created_at, ea.updated_at, e.name from employee_attendances as ea, employees as e where ea.employee_id = e.id " . $condition . "");

        // employee wise total late, total early out, total absent, total present, total weekend, total days, total working days, total working hours and status query
        $attendance = DB::select("SELECT ea.id, ea.employee_id, date(ea.created_at) as date, ea.created_at, ea.updated_at, e.name from employee_attendances as ea, employees as e where ea.employee_id = e.id " . $condition . "");
        // echo '<pre>'; print_r($attendance); die;

        $html = '<table class="table table-bordered border-primary table-hover text-center" id="" width="100%" cellspacing="0">
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
                <th>Total Days</th>
                <th>Total Working Days</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';
        $total_late = $total_present = $total_absent = $total_weekend = $total_early_out = 0;
        foreach ($attendance_day as $key => $date) {
            $item = collect($attendance)->where('date', $date)->first();
            // print_r($item); die;

            if ($item) {
                if (date('D', strtotime($item->created_at)) == 'Fri' || date('D', strtotime($item->created_at)) == 'Sat') {
                    $total_weekend++;
                } elseif (date('H:i', strtotime($item->created_at)) > '09:00' || date('H:i', strtotime($item->updated_at)) < '17:00') {
                    if (date('H:i', strtotime($item->created_at)) > '09:00') {
                        $total_late++;
                    }
                    if (date('H:i', strtotime($item->updated_at)) < '17:00') {
                        $total_early_out++;
                    }
                } else {
                    $total_present++;
                }

                $html .= '<tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $item->name . '</td>
                            <td>' . $total_late . '</td>
                            <td>' . $total_early_out . '</td>
                            <td>' . ($total_late + $total_early_out) . '</td>
                            <td>' . $total_absent . '</td>
                            <td>' . $total_present . '</td>
                            <td>' . $total_weekend . '</td>
                            <td>' . count($attendance_day) . '</td>
                            <td>' . (count($attendance_day) - $total_weekend) . '</td>
                            <td>
                                
                            </td>
                        </tr>';
            } else {
                if (date('D', strtotime($date)) == 'Fri' || date('D', strtotime($date)) == 'Sat') {
                    $total_weekend++;
                } else {
                    $total_absent++;
                }
                
                $html .= '<tr>
                            <td>' . ($key + 1) . '</td>
                            <td></td>
                            <td>' . $total_late . '</td>
                            <td>' . $total_early_out . '</td>
                            <td>' . ($total_late + $total_early_out) . '</td>
                            <td>' . $total_absent . '</td>
                            <td>' . $total_present . '</td>
                            <td>' . $total_weekend . '</td>
                            <td>' . count($attendance_day) . '</td>
                            <td>' . (count($attendance_day) - $total_weekend) . '</td>
                            <td>
                                
                            </td>
                        </tr>';
            }
        }

        $html .= '</tbody>
        </table>';
        $html .= '<table class="table table-bordered border-primary table-hover text-center" id="" width="100%" cellspacing="0">';
        $html .=    '<tr class="bg-primary text-white">
                        <td class="text-right">Total Present</td>
                        <td>' . $total_present . '</td>
                        <td class="text-right">Total Absent</td>
                        <td>' . $total_absent . '</td>
                        <td class="text-right">Total Weekend</td>
                        <td>' . $total_weekend . '</td>
                        <td class="text-right">Total Late</td>
                        <td>' . $total_late . '</td>
                    </tr>
                    <tr class="bg-primary text-white">
                        <td class="text-right">Total Early Out</td>
                        <td>' . $total_early_out . '</td>
                        <td class="text-right">Total Days</td>
                        <td>' . count($attendance_day) . '</td>
                        <td class="text-right">Total Working Days</td>
                        <td>' . (count($attendance_day) - $total_weekend) . '</td>
                        <td class="text-right">Total Working Hours</td>
                        <td>' . ((count($attendance_day) - $total_weekend) * 8) . '</td>
                    </tr>';
        $html .= '</table>';

        return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully.', 'html' => $html]);
    }
}
