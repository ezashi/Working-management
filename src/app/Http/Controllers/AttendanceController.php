<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakTime;
use App\Http\Requests\CheckInRequest;
use App\Http\Requests\CheckOutRequest;
use App\Http\Requests\BreakStartRequest;
use App\Http\Requests\BreakEndRequest;
use App\Http\Requests\AttendanceUpdateRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
  public function index()
  {
    $user = auth()->user();
    $currentStatus = $user->currentStatus();
    $todayAttendance = $user->todayAttendance();
    $currentTime = Carbon::now()->format('Y年m月d日 H:i:s');

    return view('dashboard', compact('currentStatus', 'todayAttendance', 'currentTime'));
  }
}
