@extends('layouts/layout')
@section('content')
<?php 
$array = session('add');
var_dump(session('add'));
var_dump($b = array_search(1, $array));
unset($array[$b]);
var_dump($array);
// foreach($a as $a){
//     echo $a;
// }

?>
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
                                <button type="button" class="btn search-btn" onclick="location.href='{{ route('administrator', ['category_id' => $category->id]) }}'">{{ $category->category }}</button>
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
                        <form action="{{ route('administrator') }}" method="get">
                            <input class="search" type="search" name='keyword' placeholder="キーワードを入力" >
                            <input type="submit">
                            <input type="submit" value="クリア" name='param' formaction="{{ route('administrator') }}">
                        </form>
                    </td>
                </th>
            </table>
        </div>

        <div class="foods food-items">
            @foreach($foods as $food)
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
                                    <td height="1rem" width="68">炭水化物：</td>
                                    <td>{{ $food->carbohydrate }}g</td>
                                </tr>
                                <tr class="text-right">
                                    <td width="68">タンパク質：</td>
                                    <td>{{ $food->protain }}g</td>
                                </tr>
                                <tr class="text-right">
                                    <td width="68">脂質：</td>
                                    <td>{{ $food->fat }}g</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="food-submit">
                    <button type="button" class="btn search-btn" onclick="location.href='{{ route('add_food', ['id' => $food->id]) }}'">＋</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="right-container">
    <div class="container">
        @foreach($foods as $food)
        @if(in_array($food->id, session('add')))
            <div class="food-item-right">
                <div class="food-main">
                    <div class="food-image recipe-image recipe-right-image">
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
                                    <td height="1rem" width="68">炭水化物：</td>
                                    <td>{{ $food->carbohydrate }}g</td>
                                </tr>
                                <tr class="text-right">
                                    <td width="68">タンパク質：</td>
                                    <td>{{ $food->protain }}g</td>
                                </tr>
                                <tr class="text-right">
                                    <td width="68">脂質：</td>
                                    <td>{{ $food->fat }}g</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="amount-box">
                        <form action="{{ route('administrator') }}" method="get">
                            <input type="submit" value="gで指定" name='gram' class="gram hide-box" formaction="{{ route('administrator') }}">
                            <div class="recipe-text-box">
                                <input type="text" class="garm-text hide-box">
                                <p>個</p>
                            </div>
                            <input type="submit" value="個数で指定" name='amount' class="amount" formaction="{{ route('administrator') }}">
                            <div class="recipe-text-box">
                                <input type="text" class="amount-text">
                                <p>g</p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="food-submit">
                    <button type="button" class="btn search-btn" onclick="location.href='{{ route('remove_food', ['id' => $food->id]) }}'">ー</button>
                </div>
            </div>
        @endif
        @endforeach
        <div class="container">
            <p class="param-ttl">レシピ名<span class="required">＊</span></p>
            <input type="text" name='name' class="w-100">
            <p class="param-ttl">画像</p>
            <div class="recipe-img recipe-image-form">
                <img src="{{ asset('image/default.png') }}" alt="" class="" >
                <input type="file" name="image" class="mt-2">
            </div>
            <p class="param-ttl">メモ</p>
            <textarea name="memo" id="" cols="30" rows="5" class="w-100"></textarea>
            <table border="1" class="w-100 mt-3 barance-table">
                <th> 
                    <td>合計</td>
                    <td>目標値(一食)</td>
                </th>
                <tr>
                    <td>エネルギー</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>炭水化物</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>タンパク質</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>脂質</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <p class="param-ttl">アドバイス</p>
            <div class="p-2 border border-2 border-secondary rounded rounded-3 ">
                <p>a</p>
            </div>
        </div>
    </div>
</div>

@endsection