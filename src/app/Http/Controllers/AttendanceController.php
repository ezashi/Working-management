<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BreakTime;
use App\Http\Requests\CheckInRequest;
use App\Http\Requests\CheckOutRequest;
use App\Http\Requests\BreakStartRequest;
use App\Http\Requests\BreakEndRequest;
use App\Http\Requests\AttendanceUpdateRequest;
use App\Http\Requests\ModificationRequestStoreRequest;
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



  public function list(Request $request)
  {
    $user = auth()->user();
    $month = $request->get('month', now()->format('Y-m'));
    $date = Carbon::parse($month . '-01');

    $attendances = $user->attendances()
    ->whereYear('date', $date->year)
    ->whereMonth('date', $date->month)
    ->orderBy('date', 'desc')
    ->with('breaks')
    ->get();

    $prevMonth = $date->copy()->subMonth()->format('Y-m');
    $nextMonth = $date->copy()->addMonth()->format('Y-m');

    return view('list', compact('attendances', 'month', 'prevMonth', 'nextMonth'));
  }



  public function show(Attendance $request)
  {
    dd([
      'attendance_user_id' => $attendance->user_id,
      'auth_id' => auth()->id(),
      'auth_user' => auth()->user(),
      'is_admin' => auth()->user() ? auth()->user()->isAdmin() : null,
      'comparison' => $attendance->user_id === auth()->id(),
    ]);
    if ($attendance->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
      abort(403);
    }

    $attendance->load('breaks');

    return view('attendances.show', compact('attendance'));
  }


  public function update(AttendanceUpdateRequest $request, Attendance $attendance)
  {
    if ($attendance->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
      abort(403);
    }

    $modificationRequest = ModificationRequest::create([
      'attendance_id' => $attendance->id,
      'user_id' => auth()->id(),
      'modified_check_in' => $request->check_in,
      'modified_check_out' => $request->check_out,
      'modified_breaks' => $this->processBreaks($request->breaks),
      'modified_note' => $request->note,
      'note' => $request->note,
      'status' => 'pending',
    ]);

    return redirect()->route('attendances.show', $attendance)->with('success', '*申請待ちのため修正はできません。');
    }
}