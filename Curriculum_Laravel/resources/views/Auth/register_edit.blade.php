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
            <form action="/user_edit" method="POST">
              @csrf
              <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $user['name'] }}" />
              </div>
              <div class="form-group">
                <label for="gender">性別</label>
                <select name="gender">
                  <option value="男性" @if(old('gender') === '男性') selected @elseif($user['gender'] === '男性' && !old('gender')) selected @endif>男性</option>
                  <option value="女性" @if(old('gender') === '女性') selected @elseif($user['gender'] === '女性' && !old('gender')) selected @endif>女性</option>
                </select>              
              </div>
              <div class="form-group">
                <label for="birthday">生年月日</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') ? old('birthday') : $user['birthday'] }}" />
              </div>
              <div class="form-group">
                <label for="height">身長</label>
                <input type="text" class="form-control" id="height" name="height" value="{{ old('height') ? old('height') : $user['height'] }}"/>
              </div>
              <div class="form-group">
                <label for="weight">体重</label>
                <input type="text" class="form-control" id="weight" name="weight" value="{{ old('weight') ? old('weight') : $user['weight'] }}" />
              </div>
              <div class="form-group">
                <label for="exercise_level">身体運動レベル</label>
                <select name="exercise_level">
                  <option value=1.5 @if(old('exercise_level') == 1.5) selected @elseif($user['exercise_level'] === 1.5 && !old('exercise_level')) selected @endif>低い</option>
                  <option value=1.75 @if(old('exercise_level') == 1.75) selected @elseif($user['exercise_level'] === 1.75 && !old('exercise_level')) selected @endif>普通</option>
                  <option value=2.0 @if(old('exercise_level') == 2.0) selected @elseif($user['exercise_level'] === 2.0 && !old('exercise_level')) selected @endif>高い</option>
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