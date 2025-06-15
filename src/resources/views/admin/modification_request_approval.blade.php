@extends('layouts.admin')
@section('content')
<div>
  <h2>勤怠詳細</h2>
  <form action="{{ route('modification.request.approval', $modificationRequest) }}" method="POST">
    @csrf
    <div>
      <h3>申請情報</h3>
      <div>
        <h3>名前</h3>
        <p>{{ $attendance->user->name }}</p>
      </div>
      <div>
        <h3>日付</h3>
        <p>{{ $attendance->date->format('Y年   m月d日') }}</p>
      </div>
      <div>
        <h3>出勤・退勤</h3>
        <p>{{ $modificationRequest->modified_check_out ?? '-' }} ~ {{ $modificationRequest->attendance->check_out ?? '-' }}</p>
      </div>
      <div>
        <h3>休憩</h3>
        <p>
          @if($modificationRequest->modified_breaks)
            @foreach($modificationRequest->modified_breaks as $index => $break)
              休憩{{ $index + 1 }}: {{ $break['start_time'] }} ~ {{ $break['end_time'] ?? '未終了' }}<br>
            @endforeach
          @else
            -
          @endif
        </p>
      </div>
      <div>
        <h3>備考</h3>
        <p>{{ $modificationRequest->modified_note ?? '-' }}</p>
      </div>
    </div>
    <button type="submit">承認</button>
  </form>
</div>
@endsection