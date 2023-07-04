<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('employee.attendance');
    }

    public function showAttendance(Request $request)
    {
        $show = $request->show;
        $employee_id = Auth::guard('employee')->user()->id;
        if ($show == 1) {
            $from_date = date('Y') . '-' . date('m') . '-01';
            $to_date = date('Y') . '-' . date('m') . '-' . date('t', strtotime($from_date));
            if ($to_date >= date('Y-m-d')) {
                $to_date = date('Y-m-d');
            }

            $attendance_day = [];
            $period_attebdabce = CarbonPeriod::create($from_date, $to_date);
            foreach ($period_attebdabce as $date) {
                array_push($attendance_day, $date->format('Y-m-d'));
            }

            $attendance = DB::select("SELECT id, employee_id, date(created_at) as date, created_at, updated_at from employee_attendances where employee_id = '" . $employee_id . "'");

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
                    <th>Early Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

            $total_present = $total_late = $total_weekend = $total_absent = $total_early_out = 0;
            foreach ($attendance_day as $key => $date) {
                $item = collect($attendance)->where('date', $date)->first();
                $status = '';
                $status_2 = '';
                $bgColor = '';
                if ($item) {
                    if (date('D', strtotime($item->created_at)) == 'Fri' || date('D', strtotime($item->created_at)) == 'Sat') {
                        $status = '<span class="badge badge-info">Weekend</span>';
                        $bgColor = 'bg-light';
                        $total_weekend++;
                    } elseif (date('H:i', strtotime($item->created_at)) > '09:00' || date('H:i', strtotime($item->updated_at)) < '17:00') {
                        if (date('H:i', strtotime($item->created_at)) > '09:00') {
                            $status = '<span class="badge badge-warning">Late</span>';
                            $bgColor = '';
                            $total_late++;
                        }
                        if (date('H:i', strtotime($item->updated_at)) < '17:00') {
                            $status_2 = '<span class="badge badge-warning">Early Out</span>';
                            $bgColor = '';
                            $total_early_out++;
                        }
                    } else {
                        $status = '<span class="badge badge-success">Present</span>';
                        $bgColor = '';
                        $total_present++;
                    }

                    $html .= '<tr class="' . $bgColor . '">
                                <td>' . ($key + 1) . '</td>
                                <td>' . date('d-m-Y', strtotime($item->created_at)) . '</td>
                                <td>' . date('D', strtotime($item->created_at)) . '</td>
                                <td>9:00 AM</td>
                                <td>5:00 PM</td>
                                <td>' . date('h:i A', strtotime($item->created_at)) . '</td>
                                <td>' . date('h:i A', strtotime($item->updated_at)) . '</td>
                                <td> ' . (date('H:i', strtotime($item->created_at)) > '09:00' ? (strtotime(date('h:i A', strtotime($item->created_at))) - strtotime('09:00 AM')) / 60 : 0) . ' </td>
                                <td> ' . (date('H:i', strtotime($item->updated_at)) < '17:00' ? (strtotime('05:00 PM') - strtotime(date('h:i A', strtotime($item->updated_at)))) / 60 : 0) . ' </td>
                                <td>
                                    ' . $status . ' ' . $status_2 . '
                                </td>
                            </tr>';
                } else {
                    if (date('D', strtotime($date)) == 'Fri' || date('D', strtotime($date)) == 'Sat') {
                        $status = '<span class="badge badge-info">Weekend</span>';
                        $bgColor = 'bg-light';
                        $total_weekend++;
                    } else {
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
                                <td>0</td>
                                <td>
                                    ' . $status . '
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

    public function storeAttendance(Request $request)
    {
        $todayAttendance = EmployeeAttendance::where('employee_id', Auth::guard('employee')->user()->id)
            ->whereDate('created_at', date('Y-m-d'))->first();

        if ($todayAttendance) {
            if (date('H:i') > '19:00') {
                return response()->json(['status' => 'error', 'message' => 'Out time cannot be greater than 07:00 PM.']);
            }
            $todayAttendance->updated_at = date('Y-m-d H:i:s');
            $todayAttendance->save();
            return response()->json(['status' => 'success', 'message' => 'Out time updated successfully.']);
        } else {
            if (date('H:i') < '08:00') {
                return response()->json(['status' => 'error', 'message' => 'In time cannot be less than 08:00 AM.']);
            }
            if (date('H:i') > '17:00') {
                return response()->json(['status' => 'error', 'message' => 'In time cannot be greater than 05:00 PM.']);
            }
            if (date('D') == 'Fri' || date('D') == 'Sat') {
                return response()->json(['status' => 'error', 'message' => 'Cannot attendance on weekend.']);
            }

            $attendance = new EmployeeAttendance();
            $attendance->employee_id = $request->employee_id;
            $attendance->save();
            return response()->json(['status' => 'success', 'message' => 'Attendance taken successfully.']);
        }
    }
}
