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