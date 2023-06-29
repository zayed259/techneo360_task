<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->guard('admin')->check()) {
            return view('admin.dashboard');
        } elseif (auth()->guard('employee')->check()) {
            return view('employee.dashboard');
        } else {
            return redirect()->route('login');
        }
    }
}
