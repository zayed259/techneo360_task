<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('employee.report');
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

        $employee_id = Auth::guard('employee')->user()->id;

        $condition = "";
        if($searchOption == 1) {
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
                $condition = " and year(created_at) = '" . $year . "' and month(created_at) = '" . $month . "'";
            }
        } elseif($searchOption == 2) {
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
                $condition = " and date(created_at) between '" . $from_date . "' and '" . $to_date . "'";
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Please select search option.']);
        }

        $attendance = DB::select("SELECT id, employee_id, date(created_at) as date, created_at, updated_at from employee_attendances where employee_id = '" . $employee_id . "' " . $condition . " order by created_at desc");

        $employee_joining_date = DB::select("SELECT joining_date from employee_details where employee_id = '" . $employee_id . "'");
        if ($employee_joining_date) {
            $employee_joining_date = $employee_joining_date[0]->joining_date;
            if ($from_date < $employee_joining_date) {
                return response()->json(['status' => 'error', 'message' => 'Cannot show attendance report if attendance date is less than employee joining date.']);
            }
        }

        $attendance_day = [];
        $period_attebdabce = CarbonPeriod::create($from_date, $to_date);
        foreach ($period_attebdabce as $date) {
            array_push($attendance_day, $date->format('Y-m-d'));
        }
        // print_r($attendance_day); die;

        $html = view('employee.report_tbl', compact('attendance', 'attendance_day'));
        $html = (string) $html;

        return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully.', 'html' => $html]);
    }
}
