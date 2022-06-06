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
                                <button type="button" class="btn search-btn" onclick="location.href='{{ route('register', ['category_id' => $category->id]) }}'">{{ $category->category }}</button>
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
                        <form action="{{ route('register') }}" method="get">
                            <input class="search" type="search" name='keyword' placeholder="キーワードを入力" >
                            <input type="submit"　value="検索">
                            <input type="submit" value="クリア" name='param' formaction="{{ route('register') }}">
                        </form>
                    </td>
                </th>
            </table>
        </div>

        <div class="foods food-items">
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
                            <div id= "{{ 'num-box-' . $food->id }}" class = "d-none">
                                <input type="button" value="gで指定" name='num' class="num" id = "{{ 'num-change-' . $food->id }}">
                                <div class="recipe-text-box" id = "{{ 'num-' . $food->id }}">
                                    <input type="text" name ="{{ 'num-' . $food->id }}" class="num-text " id = "{{ 'num-text-' . $food->id }}">
                                    <p class = "">個</p>
                                </div>
                            </div>
                            <div id = "{{ 'amount-box-' . $food->id }}" class="">
                                <input type="button" value="個数で指定" name='amount' class="amount" id = "{{ 'amount-change-' . $food->id }}">
                                <div class="recipe-text-box" id = "{{ 'amount-' . $food->id }}">
                                    <input type="text" name ="{{ 'amount-' . $food->id }}" class = "amount-text" id = "{{ 'amount-text-' . $food->id }}" value=100>
                                    <p>g</p>
                                </div>
                            </div>
                            <?php 
                            $id = json_encode($food->id);
                            $carbohydrate = json_encode($food->carbohydrate);
                            $protain = json_encode($food->protain);
                            $fat = json_encode($food->fat);
                            $general_weight = json_encode($food->general_weight);
                            ?> 
                            <script>
                                window.addEventListener('DOMContentLoaded', function(){
                                    var id = JSON.parse('<?php echo $id; ?>');
                                    var carbohydrate = JSON.parse('<?php echo $carbohydrate; ?>');
                                    var protain = JSON.parse('<?php echo $protain; ?>');
                                    var fat = JSON.parse('<?php echo $fat; ?>');
                                    var energy = carbohydrate * 4 + protain * 4 + fat * 9;
                                    var general_weight = JSON.parse('<?php echo $general_weight; ?>');
                                    var energy_id = document.getElementById('energy-' + id);
                                    var carbohydrate_id = document.getElementById('carbohydrate-' + id);
                                    var protain_id = document.getElementById('protain-' + id);
                                    var fat_id = document.getElementById('fat-' + id);
                                    var gram = document.getElementById('amount-text-' + id);
                                    var num = document.getElementById('num-text-' + id);
                                    var num_change = document.getElementById('num-change-' + id);
                                    var amount_change = document.getElementById('amount-change-' + id);
                                    var num_box = document.getElementById('num-box-' + id);
                                    var amount_box = document.getElementById('amount-box-' + id);
                                    gram.addEventListener("input",function(){
                                        var g = Number(gram.value);    
                                        if (Number.isInteger(g)){
                                            var energy_change = Math.round((energy * g / 100)*10)/10;
                                            var carbohydrate_change = Math.round((carbohydrate * g / 100)*10)/10;
                                            var protain_change = Math.round((protain * g / 100)*10)/10;
                                            var fat_change = Math.round((fat * g / 100)*10)/10;
                                            energy_id.textContent = energy_change + 'g';
                                            carbohydrate_id.textContent = carbohydrate_change + 'g';
                                            protain_id.textContent = protain_change + 'g';
                                            fat_id.textContent = fat_change + 'g';
                                        }
                                    });
                                    num.addEventListener("input",function(){
                                        var n = Number(num.value);    
                                        if (Number.isInteger(n)){
                                            var energy_change = Math.round((energy * general_weight / 100 * n)*10)/10;
                                            var carbohydrate_change = Math.round((carbohydrate * general_weight / 100 * n)*10)/10;
                                            var protain_change = Math.round((protain * general_weight / 100 * n)*10)/10;
                                            var fat_change = Math.round((fat * general_weight / 100 * n)*10)/10;
                                            energy_id.textContent = energy_change + 'g';
                                            carbohydrate_id.textContent = carbohydrate_change + 'g';
                                            protain_id.textContent = protain_change + 'g';
                                            fat_id.textContent = fat_change + 'g';
                                        }
                                    });

                                    num_change.addEventListener("click",function(){
                                        amount_box.classList.remove('d-none');
                                        num_box.classList.add('d-none');
                                        gram.value = 100;
                                        num.value = null;
                                        energy_id.testContent = energy + 'g';
                                        carbohydrate_id.textContent = carbohydrate + 'g';
                                        protain_id.textContent = protain + 'g';
                                        fat_id.textContent = fat + 'g';
                                    });
                                    amount_change.addEventListener("click",function(){
                                        num_box.classList.remove('d-none');
                                        amount_box.classList.add('d-none');
                                        var energy_num = Math.round((energy * general_weight / 100)*10)/10;
                                        var carbohydrate_num = Math.round((carbohydrate * general_weight / 100)*10)/10;
                                        var protain_num = Math.round((protain * general_weight / 100)*10)/10;
                                        var fat_num = Math.round((fat * general_weight / 100)*10)/10;
                                        gram.value = null;
                                        num.value = 1;
                                        energy_id.textContent = energy_num + 'g';
                                        carbohydrate_id.textContent = carbohydrate_num + 'g';
                                        protain_id.textContent = protain_num + 'g';
                                        fat_id.textContent = fat_num + 'g';
                                        
                                    });
                                });
                            </script> 
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