<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::guard('admin')->check()) {
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        } else if (Auth::guard('employee')->check()) {
            // status check for employee
            if (Auth::guard('employee')->user()->status == 0) {
                Auth::guard('employee')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                    'email' => 'Your account has been disabled.'
                ]);
            }
            return redirect()->intended(RouteServiceProvider::EMPLOYEE_HOME);
        } else {
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => 'These credentials do not match our records.'
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } elseif (Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } else {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return redirect()->route('home');
    }
}
