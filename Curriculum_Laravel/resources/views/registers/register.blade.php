@extends('layouts/layout')
@section('content')

<div class="left-container">
    <div class="container">
        <div class="search-items">
            <div class="">
                <table>
                    <th>
                        <td width="80" class="text-right">
                            <div class="search-logo">
                                並び替え：
                            </div>
                        </td>
                        @foreach($categories as $category)
                            <td>    
                                <button type="button" class="btn search-btn" onclick="location.href='{{ route('registers', ['category_id' => $category->id]) }}'">{{ $category->category }}</button>
                            </td>
                        @endforeach
                    </th>
                </table>
            </div>
            <table class="mt-1 mb-3"　>
                <th>
                    <td width="80" class="text-right">
                        <div class="search-logo">
                            食材名：
                        </div>
                    </td>
                    <td valign="middle">
                        <form action="{{ route('registers') }}" method="get">
                            <input type="hidden" id="judge" value=1>
                            <input type="hidden" id="count" value=10>
                            <input type='hidden' id="keyword" value='{{ $keyword }}'>
                            <input type='hidden' id="clear" value='{{ $clear }}'>
                            <input type='hidden' id="category_id" value='{{ $category_id }}'>
                            <input class="search" type="search" name='keyword' placeholder="キーワードを入力" >
                            <input type="submit" value="検索">
                            <input type="submit" value="クリア" name='param' formaction="{{ route('registers') }}">
                        </form>
                    </td>
                </th>
            </table>
        </div>

        <div id="register-foods" class="foods food-items">
            @foreach($foods as $food)
            <form action="{{ route('add_food', ['id' => $food->id]) }}" method="get">
                <div class="food-item">
                    <div class="food-main">
                        <div class="food-image recipe-image">
                            <img src="{{ asset($food->image) }}" alt="{{ $food->image }}" class="">
                        </div>
                        <div class="food-info recipe-info">
                            <div class="info-container">
                                <div class="mb-2 hide">
                                    {{ $food->name }} 
                                </div>
                                <p class="hide">100gあたり(1 {{ $food->unit }} {{ $food->general_weight }} g )</p>
                                <table class="food-table">
                                    <tr class="text-right">
                                        <td height="1rem" width="68">エネルギー：</td>
                                        <td id="{{ 'energy-' . $food->id }}">{{ $food->carbohydrate * 4 + $food->protain * 4 + $food->fat * 9 }}kcal</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td height="1rem" width="68">炭水化物：</td>
                                        <td id="{{ 'carbohydrate-' . $food->id }}">{{ $food->carbohydrate }}g</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td width="68">タンパク質：</td>
                                        <td id="{{ 'protain-' . $food->id }}">{{ $food->protain }}g</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td width="68">脂質：</td>
                                        <td id="{{ 'fat-' . $food->id }}">{{ $food->fat }}g</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="amount-boxes">
                            <form onsubmit="return false;"> 
                                <input type="hidden" value="100" id="{{'data-' . $food->id}}" >
                                <div id= "{{ 'num-box-' . $food->id }}" class = "d-none">
                                    <input type="button" value="gで指定" name='num' class="change1 num" id = "{{ 'num-change-' . $food->id }}" data-id="{{ $food->id }}" data-carbohydrate="{{ $food->carbohydrate }}" data-protain="{{ $food->protain }}" data-fat="{{ $food->fat }}" data-general_weight="{{ $food->general_weight }}">
                                    <div class="recipe-text-box" id = "{{ 'num-' . $food->id }}">
                                        <input type="text" name ="{{ 'num-' . $food->id }}" class="change2 num-text" id = "{{ 'num-text-' . $food->id }}" data-id="{{ $food->id }}" data-carbohydrate="{{ $food->carbohydrate }}" data-protain="{{ $food->protain }}" data-fat="{{ $food->fat }}" data-general_weight="{{ $food->general_weight }}">
                                        <p class = "">個</p>
                                    </div>
                                </div>
                                <div id = "{{ 'amount-box-' . $food->id }}" class="">
                                    <input type="button" value="個数で指定" name='amount' class="change3 amount" id = "{{ 'amount-change-' . $food->id }}" data-id="{{ $food->id }}" data-carbohydrate="{{ $food->carbohydrate }}" data-protain="{{ $food->protain }}" data-fat="{{ $food->fat }}" data-general_weight="{{ $food->general_weight }}">
                                    <div class="recipe-text-box" id = "{{ 'amount-' . $food->id }}">
                                        <input type="text" name ="{{ 'amount-' . $food->id }}" class = "change4 amount-text" id = "{{ 'amount-text-' . $food->id }}" value=100 data-id="{{ $food->id }}" data-carbohydrate="{{ $food->carbohydrate }}" data-protain="{{ $food->protain }}" data-fat="{{ $food->fat }}" data-general_weight="{{ $food->general_weight }}" >
                                        <p>g</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="food-submit">
                        <button type="submit" class="btn search-btn">＋</button>
                    </div>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</div>
<div class="right-container">
    <div class="container">
        <div class="container foods-name">
            <p class="param-ttl">食材<span class="required">＊</span></p>
        </div>
        @if(isset($add_foods))
        @foreach($add_foods as $food)
            <div class="food-item-right">
                <div class="food-main">
                    <div class="food-image recipe-image recipe-right-image">
                        <img src="{{ asset($food["image"]) }}" alt="{{ $food["image"] }}" class="">
                    </div>
                    <div class="food-info recipe-info">
                        <div class="info-container">
                            <div class="mb-2 hide">
                                {{ $food["name"] }} 
                            </div>
                            <table class="food-table">
                                <tr class="text-right">
                                    <td height="1rem" width="68">エネルギー：</td>
                                    <td>{{ $food["carbohydrate"] * $food["amount"] / 100 * 4 + $food["protain"] * $food["amount"] / 100 * 4 + $food["fat"] * $food["amount"] / 100 * 9 }}kcal</td>
                                </tr>
                                <tr class="text-right">
                                    <td>炭水化物：</td>
                                    <td>{{ $food["carbohydrate"] * $food["amount"] / 100 }}g</td>
                                </tr>
                                <tr class="text-right">
                                    <td width="68">タンパク質：</td>
                                    <td>{{ $food["protain"] * $food["amount"] / 100 }}g</td>
                                </tr>
                                <tr class="text-right">
                                    <td width="68">脂質：</td>
                                    <td>{{ $food["fat"] * $food["amount"] / 100 }}g</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="amount-boxes">
                        <div>
                            <p>分量</p>
                            <p>グラム：{{ $food["amount"] }}g</p>
                            <p>(個数：{{ round($food["amount"] / $food["general_weight"], 2) }} {{ $food["unit"] }})</p>
                            <p class="hide">(1 {{ $food["unit"] }} {{ $food["general_weight"] }} g )</p>
                        </div>
                    </div>
                </div>
                <div class="food-submit">
                    <button type="button" class="btn search-btn" onclick="location.href='{{ route('remove_food', ['id' => $food['food_id']]) }}'">ー</button>
                </div>
            </div>
        @endforeach
        @endif
        <div class="container">
            <p class="param-ttl">栄養バランス</p>
            <table border="1" class="w-100 barance-table">
                <th> 
                    <td>合計</td>
                    <td>目標値(一食)</td>
                </th>
                <tr>
                    <td width="20%">エネルギー</td>
                    <td width="20%">{{ $sum['energy'] }}kcal</td>
                    <td width="80%">摂取エネルギーに対するバランス↓↓</td>
                </tr>
                <tr>
                    <td>炭水化物</td>
                    <td>{{ $sum['carbohydrate'] }}g</td>
                    <td>{{ $target['carbohydrate_lower'] }}g~{{ $target['carbohydrate_upper'] }}g</td>
                </tr>
                <tr>
                    <td>タンパク質</td>
                    <td>{{ $sum['protain'] }}g</td>
                    <td>{{ $target['protain_lower'] }}g~{{ $target['protain_upper'] }}g</td>
                </tr>
                <tr>
                    <td>脂質</td>
                    <td>{{ $sum['fat'] }}g</td>
                    <td>{{ $target['fat_lower'] }}g~{{ $target['fat_upper'] }}g</td>
                </tr>
            </table>

            <p class="param-ttl">アドバイス</p>
            <div class="p-2 mb-5 border border-2 border-secondary rounded rounded-3 ">
                @foreach($alerts as $alert)
                <p>{{ $alert }}</p>
                @endforeach
            </div>
            
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="/registers" method="POST" enctype="multipart/form-data">
                @csrf
                <p class="param-ttl">レシピ名<span class="required">＊</span></p>
                <input type="text" name='name' class="w-100" value="{{ old('name') }}">
                <p class="param-ttl">画像</p>
                <div class="recipe-img recipe-image-form food-img-content submit-img">
                    <img src="{{ asset('image/default.png') }}" alt="" class="" >
                    <input type="file" name="image" class="mt-2">
                </div>
                @if(old())
                  <p class="old-image">※写真を選択した場合は再度選択してください</p>
                @endif
                <p class="param-ttl">メモ</p>
                <textarea name="memo" id="" cols="30" rows="5" class="w-100">{{ old('memo') }}</textarea>
                <p class="param-ttl">食事記録に反映させる場合は日付を選択して下さい。</p>
                <p class="">選択しない場合はレシピのみ登録されます。</p>
                <input type="date" name="date" value="{{ old('date') }}">
                <div class="text-right">
                    <button type="submit" class="btn btn-dark">レシピ登録</button>
                </div>
            </form>
        </div>
        
    </div>
</div>




@endsection