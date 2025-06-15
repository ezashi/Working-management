<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;

class AdminLoginController extends Controller
{
  public function showLogin()
  {
    if (Auth::check() && Auth::user()->isAdmin()) {
      return redirect()->route('admin.attendance');
    }

    return view('admin.auth.login');
  }


  public function login(AdminLoginRequest $request)
  {
    $request->authenticate();

    $request->session()->regenerate();

    return redirect()->route('admin.attendance');
  }


  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login');
  }
}