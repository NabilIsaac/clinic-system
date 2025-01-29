<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('patient')) {
            return redirect()->route('patient.dashboard');
        } elseif ($user->hasRole('doctor')) {
            return redirect()->route('doctor.dashboard');
        } elseif ($user->hasRole('nurse')) {
            return redirect()->route('nurse.dashboard');
        } elseif ($user->hasRole('staff')) {
            return redirect()->route('staff.dashboard');
        } elseif ($user->hasRole('super-admin')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }
}
