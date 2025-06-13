@extends('layouts.app')
@section('content')
<div>
  <h2>勤務詳細</h2>
  <form action="{{ route('attendances.update', $attendance }}" method="post">
    @csrf
    @method('put')
    <div>
      <div>
        <h3>名前</h3>
        <p>{{ $attendance->user->name }}</p>
      </div>
      <div>
        <h3>日付</h3>
        <p>{{ $attendance->date->format('Y年   m月d日') }}</p>
      </div>
    </div>

    <div>
      <div>
        <h3>出勤・退勤</h3>
        <input type="time" name="check_in" id="check_in" value="{{ old('check_in', $attendance->check_in) }}">
        ~
        <input type="time" name="check_out" id="check_out" value="{{ old('check_out', $attendance->check_out) }}">
      </div>
      <div>
        @foreach($attendance->breaks as $index => $break)
          <h3>休憩{{ $index + 1 }}</h3>
          <input type="time" name="breaks[{{ $index }}][start_time]" value="{{ old('breaks.'.$index.'.start_time', $break->start_time) }}">
          ~
          <input type="time" name="breaks[{{ $index }}][end_time]" value="{{ old('breaks.'.$index.'.end_time', $break->end_time) }}">
        @endforeach
      </div>
      <div>
        <h3>備考</h3>
        <textarea name="note" id="note">{{ old('note', $attendance->note) }}</textarea>
      </div>
    </div>
    <div>
      <button type="submit">
        修正
      </button>
    </div>
  </form>
</div>