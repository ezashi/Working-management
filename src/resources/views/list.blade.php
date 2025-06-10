@extends('layouts.app')
@section('content')
<div>
  <h2>勤怠一覧</h2>
  <div>
    <a href="{{ route('attendances.list', ['month' => $prevMonth]) }}">
      前月
    </a>
    <span>{{ \Carbon\Carbon::parse($month)->format('Y年m月') }}</span>
    <a href="{{ route('attendances.list', ['month' => $nextMonth]) }}">
      翌月
    </a>
  </div>
  <div>
    <table>
      <thead>
        <tr>
          <th>日付</th>
          <th>出勤</th>
          <th>退勤</th>
          <th>休憩</th>
          <th>合計</th>
          <th>詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach($attendances as $attendance)
          <tr>
            <td>{{ $attendance->date->format('m/d') }}</td>
            <td>{{ $attendance->check_in ?? '' }}</td>
            <td>{{ $attendance->check_out ?? '' }}</td>
            <td>{{ $attendance->totalBreakTime() }}分</td>
            <td>{{ floor($attendance->workingHours() / 60) }}時間{{ $attendance->workingHours() % 60 }}分</td>
            <td>
              <a href="{{ route('attendances.show', $attendance) }}">詳細</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection