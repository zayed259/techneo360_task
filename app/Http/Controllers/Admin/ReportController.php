<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        } else {
            return response()->json(['status' => 'error', 'message' => 'Please select search option.']);
        }

        $query = DB::select("SELECT e.id AS employee_id, e.name,
        SUM(
        CASE
            WHEN ea.created_at BETWEEN '$from_date' AND '$to_date' THEN 1
            ELSE 0 
        END) AS total_attendance,

        SUM(
        CASE
            WHEN ea.created_at BETWEEN '$from_date' AND '$to_date' AND TIME(ea.created_at) < '09:00:00' AND TIME(ea.updated_at) > '17:00:00' THEN 1
            ELSE 0 
        END) AS total_present,

        SUM(CASE
            WHEN ea.created_at BETWEEN '$from_date' AND '$to_date' AND TIME(ea.created_at) > '09:00:00' THEN 1
            ELSE 0
        END) AS total_late,

        SUM(CASE
            WHEN ea.created_at BETWEEN '$from_date' AND '$to_date' AND TIME(ea.updated_at) < '17:00:00' THEN 1
            ELSE 0
        END) AS total_early_out

        FROM employees e LEFT JOIN employee_attendances ea
        ON e.id = ea.employee_id GROUP BY e.id");
        // echo '<pre>'; print_r($query); die;

        $startDate = Carbon::parse($from_date);
        $endDate = Carbon::parse($to_date);

        $countWeekend = 0;
        $totalDay = 0;

        for ($date = $startDate; $date <= $endDate; $date->addDay()) {
            if ($date->isFriday() || $date->isSaturday()) {
                $countWeekend++;
            }
            $totalDay++;
        }
        $workingDay = $totalDay - $countWeekend;

        $html = view('admin.report_tbl', compact('query', 'workingDay', 'countWeekend', 'totalDay'));
        $html = (string) $html;

        return response()->json(['status' => 'success', 'message' => 'Attendance updated successfully.', 'html' => $html]);
    }
}
