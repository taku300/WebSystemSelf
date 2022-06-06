@extends('layouts/layout')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header">食材登録</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="/food" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                  <label for="name">食材名<span class="required">＊</span></label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : '' }}" />
              </div>
              <div class="form-group">
                  <label for="height">炭水化物(100gあたり)<span class="required">＊</span></label>
                  <input type="text" class="form-control" id="carbohydrate" name="carbohydrate" value="{{ old('carbohydrate') ? old('carbohydrate') : ''  }}"/>
              </div>
              <div class="form-group">
                  <label for="weight">タンパク質(100gあたり)<span class="required">＊</span></label>
                  <input type="text" class="form-control" id="protain" name="protain" value="{{ old('protain') ? old('protain') : ''  }}" />
              </div>
              <div class="form-group">
                  <label for="weight">脂質(100gあたり)<span class="required">＊</span></label>
                  <input type="text" class="form-control" id="fat" name="fat" value="{{ old('fat') ? old('fat') : ''  }}" />
              </div>
              <table>
                  <tr>
                      <td><label for="general_weight">一単位(g)<span class="required">＊</span></label></td>
                      <td></td>
                      <td><label for="unit">単位<span class="required">＊</span></label></td>
                  </tr>
                  <tr>
                      <td><input type="text" class="form-control" id="general_weight" name="general_weight" value="{{ old('general_weight') ? old('general_weight') : ''  }}" /></td>
                      <td>g&emsp;</td>
                      <td><input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit') ? old('unit') : ''  }}" /></td>
                  </tr>
              </table>
              <div class="food-img-box">
                <div class="form-group d-flex flex-column mt-4 food-img-content">
                    <label for="image">写真</label>
                    <input type="file" class="" id="image" name="image" value="" />
                </div>
                <div class='submit-img'>
                  <img src="{{ asset('image/default.png') }}" alt="">
                  @if(old())
                  <p class="old-image">写真を選択した場合は再度アップロードしてください</p>
                  @endif
                </div>
              </div>
              <div>
                  <label for="category_id" class="mt-4">ジャンル<span class="required">＊</span></label>
                  <select name="category_id">
                    @foreach($categories as $key => $category)
                      <option value={{ $key }} {{ old('category_id') == $key ? 'selected' : '' }}>{{$category }}</option>
                    @endforeach
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