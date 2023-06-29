<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

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

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, "https://www.googleapis.com/oauth2/v4/token");
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, [
            'code' => request()->get('code'),
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => config('services.google.redirect'),
            'grant_type' => 'authorization_code'
        ]);
        $response = curl_exec($curlHandle);
        curl_close($curlHandle);
        $data = json_decode($response);
        $user = Http::withoutVerifying()->withToken($data->access_token)->get('https://www.googleapis.com/oauth2/v1/userinfo');
        $user = json_decode($user);
        $this->_registerOrLoginUser($user);
        return redirect()->intended(RouteServiceProvider::EMPLOYEE_HOME);
    }

    /**
     * Create a new controller instance.
     */
    private function _registerOrLoginUser($data): void
    {
        // dd($data);
        $user = Employee::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new Employee();
            $user->employee_id = rand(100000, 999999);
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->picture;
            $user->save();
        }
        Auth::guard('employee')->login($user);
    }
}
