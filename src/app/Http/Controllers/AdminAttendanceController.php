<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\ModificationRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceModificationRequest;


class AdminAttendanceController extends Controller
{
  public function attendance(Request $request)
  {
    $date = $request->get('date', now()->format('Y-m-d'));
    $targetDate = Carbon::parse($date);

    $attendances = Attendance::with(['user', 'breaks'])
      ->whereDate('date', $targetDate)
      ->orderBy('user_id')
      ->get();

    $prevDate = $targetDate->copy()->subDay()->format('Y-m-d');
    $nextDate = $targetDate->copy()->addDay()->format('Y-m-d');

    return view('admin.attendance', compact('attendances', 'date', 'prevDate', 'nextDate', 'targetDate'));
  }
}