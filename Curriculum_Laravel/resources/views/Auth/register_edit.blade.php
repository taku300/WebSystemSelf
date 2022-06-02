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
            <form action="/user_edit" method="POST">
              @csrf
              <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $user['name'] }}" />
              </div>
              <div class="form-group">
                <label for="gender">性別</label>
                <select name="gender">
                  <option value=1 @if(old('gender') === 1) selected @elseif($user['gender'] === 1 && !old('gender')) selected @endif>男性</option>
                  <option value=2 @if(old('gender') === 2) selected @elseif($user['gender'] === 2 && !old('gender')) selected @endif>女性</option>
                </select>              
              </div>
              <div class="form-group">
                <label for="birthday">生年月日</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') ? old('birthday') : $user['birthday'] }}" />
              </div>
              <div class="form-group height">
                <label for="height">身長</label>
                <input type="text" class="form-control w-50" id="height" name="height" value="{{ old('height') ? old('height') : $user['height'] }}"/>
                <div class="recommendation-weight">
                  <p>推奨体重: {{ round(22 * pow(($user['height'] / 100), 2)) }} kg</p>
                  <span class="direction">身長から計算した、日本で最も健康とされる体重(BMI22)を表示しています。<br>これを参考に目標体重を設定してください。</span>
                </div>
              </div>
              <div class="form-group">
                <label for="target_weight">目標体重</label>
                <input type="text" class="form-control w-50" id="target_weight" name="target_weight" value="{{ old('target_weight') ? old('target_weight') : $user['target_weight'] }}" />
              </div>
              <div class="form-group">
                <label for="exercise_level">身体運動レベル</label>
                <select name="exercise_level">
                  <option value=1 @if(old('exercise_level') == 1) selected @elseif($user['exercise_level'] == 1 && !old('exercise_level')) selected @endif>低い</option>
                  <option value=2 @if(old('exercise_level') == 2) selected @elseif($user['exercise_level'] == 2 && !old('exercise_level')) selected @endif>普通</option>
                  <option value=3 @if(old('exercise_level') == 3) selected @elseif($user['exercise_level'] == 3 && !old('exercise_level')) selected @endif>高い</option>
                </select>              
              </div>
              <div class="text-right">
                <button type="submit" class="btn btn-primary">送信</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection