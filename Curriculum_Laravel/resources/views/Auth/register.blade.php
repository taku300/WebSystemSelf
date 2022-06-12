@extends('layouts/layout')
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
                <label for="email">メールアドレス<span class="required">＊</span></label>
                <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" />
              </div>
              <div class="form-group">
                <label for="name">ユーザー名<span class="required">＊</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" />
              </div>
              <div class="form-group">
                <label for="password">パスワード<span class="required">＊</span></label>
                <input type="password" class="form-control" id="password" name="password" />
              </div>
              <div class="form-group">
                <label for="password-confirm">パスワード（確認）<span class="required">＊</span></label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" />
              </div>
              <div class="form-group">
                <label for="gender">性別<span class="required">＊</span></label>
                <select name="gender">
                  <option value="1" {{ old('gender') === '1' ? 'selected' : '' }}>男性</option>
                  <option value="2" {{ old('gender') === '2' ? 'selected' : '' }}>女性</option>
                </select>              
              </div>
              <div class="form-group">
                <label for="birthday">生年月日<span class="required">＊</span></label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}" />
              </div>
              <div class="form-group height">
                <label for="height">身長<span class="required">＊</span></label>
                <input type="text" class="form-control w-50" id="height" name="height" value="{{ old('height') }}"/>
                <div class="recommendation-weight">
                  <p>推奨体重:0kg</p>
                  <span class="direction">身長から計算した、日本で最も健康とされる体重(BMI22)を表示しています。<br>これを参考に目標体重を設定してください。</span>
                </div>
              </div>
              <div class="form-group">
                <label for="target_weight">目標体重<span class="required">＊</span></label>
                <input type="text" class="form-control w-50" id="target_weight" name="target_weight" value="{{ old('target_weight') }}" />
              </div>
              <div class="form-group">
                <label for="exercise_level">身体運動レベル<span class="required">＊</span></label>
                <select name="exercise_level">
                  <option value=1 {{ old('exercise_level') === '1' ? 'selected' : '' }}>低い</option>
                  <option value=2 {{ old('exercise_level') === '2' ? 'selected' : '' }}>普通</option>
                  <option value=3 {{ old('exercise_level') === '3' ? 'selected' : '' }}>高い</option>
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