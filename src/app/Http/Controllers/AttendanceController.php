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
  public function attendance()
  {
    $user = auth()->user();
    $currentStatus = $user->currentStatus();
    $todayAttendance = $user->todayAttendance();
    $currentTime = Carbon::now()->format('Y年m月d日 H:i:s');

    return view('attendance', compact('currentStatus', 'todayAttendance', 'currentTime'));
  }


  public function checkIn(CheckInRequest $request)
  {
    $attendance = Attendance::create([
      'user_id' => auth()->id(),
      'date' => today(),
      'check_in' => now()->format('H:i:s'),
      'status' => 'working',
    ]);

    return redirect()->route('attendance')->with('success', '出勤しました。');
  }


  public function checkOut(CheckOutRequest $request)
  {
    $attendance = auth()->user()->todayAttendance();
    $attendance->update([
      'check_out' => now()->format('H:i:s'),
      'status' => 'finished',
    ]);

    return redirect()->route('attendance')->with('success', 'お疲れ様でした。');
  }

  public function breakStart(BreakStartRequest $request)
  {
    $attendance = auth()->user()->todayAttendance();

    BreakTime::create([
      'attendance_id' => $attendance->id,
      'start_time' => now()->format('H:i:s'),
    ]);

    $attendance->update(['status' => 'break']);

    return redirect()->route('attendance')->with('success', '休憩を開始しました。');
  }


  public function breakEnd(BreakEndRequest $request)
  {
    $attendance = auth()->user()->todayAttendance();
    $activeBreak = $attendance->activeBreak();

    if ($activeBreak) {
      $activeBreak->update(['end_time' => now()->format('H:i:s')]);
    }

    $attendance->update(['status' => 'working']);

    return redirect()->route('attendance')->with('success', '休憩を終了しました。');
  }
}
