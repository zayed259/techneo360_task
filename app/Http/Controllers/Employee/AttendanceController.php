<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('employee.attendance');
    }

    public function showAttendance(Request $request)
    {
        $show = $request->show;
        if ($show == 1) {
            $attendance = EmployeeAttendance::where('employee_id', Auth::guard('employee')->user()->id)->orderBy('created_at', 'desc')->get()->take(30);
            $html = '';
            foreach ($attendance as $key => $item) {
                $status = '';
                $bgColor = '';
                if (date_format($item->created_at, 'D') == 'Fri' || date_format($item->created_at, 'D') == 'Sat') {
                    $status = '<span class="badge badge-warning">Weekend</span>';
                    $bgColor = 'bg-light';
                } elseif (date_format($item->created_at, 'H:i') > '09:00') {
                    $status = '<span class="badge badge-danger">Delay</span>';
                    $bgColor = '';
                } else {
                    $status = '<span class="badge badge-success">Present</span>';
                    $bgColor = '';
                }
                $item->status = $status;
                $item->bgColor = $bgColor;

                $html .= '<tr class="' . $bgColor . '">
                            <td>' . ($key + 1) . '</td>
                            <td>' . date_format($item->created_at, 'd-m-Y') . '</td>
                            <td>' . date_format($item->created_at, 'D') . '</td>
                            <td>9:00 AM</td>
                            <td>5:00 PM</td>
                            <td>' . date_format($item->created_at, 'h:i A') . '</td>
                            <td>' . date_format($item->updated_at, 'h:i A') . '</td>
                            <td> ' . (date_format($item->created_at, 'H:i') > '09:00' ? (strtotime(date_format($item->created_at, 'h:i A')) - strtotime('09:00 AM')) / 60 : 0) . ' </td>
                            <td>
                                ' . $status . '
                            </td>
                        </tr>';
            }
            return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully.', 'html' => $html]);
        }
    }

    public function storeAttendance(Request $request)
    {
        $todayAttendance = EmployeeAttendance::where('employee_id', Auth::guard('employee')->user()->id)
            ->whereDate('created_at', date('Y-m-d'))->first();

        if ($todayAttendance) {
            //update attendance
            $todayAttendance->updated_at = date('Y-m-d H:i:s');
            $todayAttendance->save();
            return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully.']);
        } else {
            $attendance = new EmployeeAttendance();
            $attendance->employee_id = $request->employee_id;
            $attendance->save();
            return response()->json(['status' => 'success', 'message' => 'Attendance taken successfully.']);
        }
    }
}
