@extends('layouts.app')
@section('content')
<div>
  <h2>申請一覧</h2>
</div>
<div>
  <div>
    <h3>申請待ち</h3>
    <table>
      <thead>
        <tr>
          <th>状態</th>
          <th>名前</th>
          <th>対象日時</th>
          <th>申請理由</th>
          <th>申請日時</th>
          <th>詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach($correctionRequests as $request)
        <tr>
          <td>
            <span>承認待ち</span>
          </td>
          <td>{{ $request->user->name }}</td>
          <td>{{ $request->date->format('Y年m月d日') }}</td>
          <td>{{ $request->note }}</td>
          <td>{{ $request->created_at->format('Y年m月d日 H:i') }}</td>
          <td>
            <a href="{{ route('attendance.show', $attendance) }}">詳細</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>