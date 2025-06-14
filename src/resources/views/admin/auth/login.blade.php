@extends('layouts.admin')
@section('content')
<div>
  <h2>管理者ログイン</h2>
</div>
<form method="POST" action="{{ route('admin.login.post') }}">
  @csrf
  <div>
    <label for="email">メールアドレス</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}">
    @error('email')
      <div class="error-message">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="password">パスワード</label>
    <input id="password" type="password" name="password">
    @error('password')
      <div class="error-message">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <button type="submit">管理者ログインする</button>
  </div>
</form>
@endsection
