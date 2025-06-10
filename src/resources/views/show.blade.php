@extends('layouts.app')
@section('content')
<div>
  <h2>勤務詳細</h2>
  <div>
    <p>
      <span>名前:</span>
      {{ $attendance->user->name }}
    </p>
    <p>
      <span>日付:</span>
      {{ $attendance->date->format('Y年   m月d日') }}
    </p>
  </div>

  <div>
    <h3>出勤・退勤</h3>
      <p>出勤時刻: {{ $attendance->check_in ?? '未打刻' }}</p>
      <p>退勤時刻: {{ $attendance->check_out ?? '未打刻' }}</p>
  </div>