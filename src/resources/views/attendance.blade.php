@extends('layouts.app')
@section('content')
<div>
  <span>
    @switch($currentStatus)
      @case('not_working')
        勤務外
        @break
      @case('working')
        勤務中
        @break
      @case('break')
        休憩中
        @break
      @case('finished')
        退勤済
        @break
    @endswitch
  </span>
  <p>
    <span id="current-time">{{ $currentTime }}</span>
  </p>
  @if($currentStatus === 'not_working')
    <form method="POST" action="{{ route('attendance.check-in') }}">
      @csrf
      <button type="submit">
        出勤
      </button>
    </form>
  @endif
  @if($currentStatus === 'working')
    <form method="POST" action="{{ route('attendance.check-out') }}">
      @csrf
      <button type="submit">
        退勤
      </button>
    </form>
    <form method="POST" action="{{ route('attendance.break-start') }}">
      @csrf
      <button type="submit">
        休憩入
      </button>
    </form>
  @endif
  @if($currentStatus === 'break')
    <form method="POST" action="{{ route('attendance.break-end') }}">
      @csrf
      <button type="submit">
        休憩戻
      </button>
    </form>
  @endif
  @if($currentStatus === 'finished')
    お疲れ様でした。
  @endif
</div>
@endsection