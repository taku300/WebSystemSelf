@extends('layouts/layout')
@section('content')
<div class="container">
    <div class="d-flex">
        <div class="recipe- detail-left w-50">
            <div class="container">
                @if($recipe->del_flg == 1)
                <div class="text-danger">
                    <p>※このレシピはすでに消去されています。</p>
                </div>
                @endif
                <div class="container foods-name">
                    <p class="param-ttl">食材</p>
                </div>
                <div class="foods">
                    @foreach($foods as $food)
                    <div class="food w-100">
                        <div class="food-main food-main-detail">
                            <div class="food-image">
                                <img src="{{ asset($food->image) }}" alt="{{ $food->image }}" class="">
                            </div>
                            <div class="food-info">
                                <div class="info-container">
                                    <div class="mb-2 hide">
                                        {{ $food->name }} 
                                    </div>
                                    <p>分量：{{ $food->amount }} g（ {{ round($food->amount/$food->general_weight , 2) }}{{ $food->unit }} ）</p>
                                    <p class="hide">（1 {{ $food->unit }} {{ $food->general_weight }} g )</p>
                                        <table class="food-table">
                                            <tr class="text-right">
                                                <td height="1rem" width="68">エネルギー：</td>
                                                <td>{{ round($food->carbohydrate  * $food->amount/100 * 4 + $food->protain  * $food->amount/100 * 4 + $food->fat  * $food->amount/100 * 9, 2) }}kcal</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td height="1rem" width="68">炭水化物：</td>
                                                <td>{{ round($food->carbohydrate  * $food->amount/100, 2) }}g</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="68">タンパク質：</td>
                                                <td>{{ round($food->protain  * $food->amount/100, 2) }}g</td>
                                            </tr>
                                            <tr class="text-right">
                                                <td width="68">脂質：</td>
                                                <td>{{ round($food->fat  * $food->amount/100, 2) }}g</td>
                                            </tr>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="recipe-detail-right w-50">
            <div class="container">
                <p class="param-ttl">レシピ名</p>
                <p>{{ $recipe->name }}</p>
                <p class="param-ttl">画像</p>
                <div class="recipe-img recipe-image-form">
                    <img src="{{ asset($recipe->image) }}" alt="" class="" >
                </div>
                <p class="param-ttl">メモ</p>
                <p>{{ $recipe->memo }}</p>
                <div>
                    <p class="param-ttl">栄養バランス</p>
                    <table border="1" class="w-100 barance-table">
                        <th> 
                            <td>合計</td>
                            <td>目標値(一食)</td>
                        </th>
                        <tr>
                            <td width="20%">エネルギー</td>
                            <td width="20%">{{ $recipe['energy'] }}kcal</td>
                            <td width="600%">摂取エネルギーに対するバランス↓↓</td>
                        </tr>
                        <tr>
                            <td>炭水化物</td>
                            <td>{{ $recipe['carbohydrate'] }}g</td>
                            <td>{{ $target['carbohydrate_lower'] }}g~{{ $target['carbohydrate_upper'] }}g</td>
                        </tr>
                        <tr>
                            <td>タンパク質</td>
                            <td>{{ $recipe['protain'] }}g</td>
                            <td>{{ $target['protain_lower'] }}g~{{ $target['protain_upper'] }}g</td>
                        </tr>
                        <tr>
                            <td>脂質</td>
                            <td>{{ $recipe['fat'] }}g</td>
                            <td>{{ $target['fat_lower'] }}g~{{ $target['fat_upper'] }}g</td>
                        </tr>
                    </table>
                    
                    <p class="param-ttl">アドバイス</p>
                    <div class="p-2 mb-5 border border-2 border-secondary rounded rounded-3 ">
                        @foreach($alerts as $alert)
                        <p>{{ $alert }}</p>
                        @endforeach
                    </div>
                </div>     
            </div>
        </div>
    </div>
</div>

@endsection