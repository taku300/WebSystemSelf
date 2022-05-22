@extends('layout/layout')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header">会員登録</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" />
              </div>
              <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" />
              </div>
              <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="form-group">
                <label for="password-confirm">パスワード（確認）</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
              </div>
              <div class="form-group">
                <label for="password-confirm">性別</label>
                <select name="gender">
                  <option value="男性">男性</option>
                  <option value="女性">女性</option>
                </select>              
              </div>
              <div class="form-group">
                <label for="password-confirm">生年月日</label>
                <input type="date" class="form-control" id="password-confirm" name="birthday">
              </div>
              <div class="form-group">
                <label for="password-confirm">身長</label>
                <input type="text" class="form-control" id="password-confirm" name="height">
              </div>
              <div class="form-group">
                <label for="password-confirm">体重</label>
                <input type="text" class="form-control" id="password-confirm" name="weight">
              </div>
              <div class="form-group">
                <label for="password-confirm">性別</label>
                <select name="exercise_level">
                  <option value=1>低い</option>
                  <option value=2>普通</option>
                </select>              
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">送信</button>
              </div>
            </form>
          </div>
        </nav>
        <div class="text-center">
          <a href="{{ route('password.request') }}">パスワードの変更はこちらから</a>
        </div>
      </div>
    </div>
  </div>
@endsection