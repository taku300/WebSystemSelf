@extends('layouts/layout')
@section('content')

<div class="container">
    <div class="">
        <button type="button" class="btn search-btn" onclick="location.href='{{ route('record.register', ['myrecipe' => 'myrecipe']) }}'">Myレシピ</button>
    </div>
    <table class="mt-1 mb-3">
        <form action="{{ route('record.register') }}" method="get">
            <tr>
                <td class="text-right">
                    <div class="search-logo">
                        レシピ名：
                    </div>
                </td>
                <td valign="middle">
                        <input class="search" type="search" name='keyword' placeholder="キーワードを入力" >
                </td>
            </tr>
            <tr>
                <td width="80" class="text-right">
                    <div class="search-logo">
                        日付：
                    </div>
                </td>
                <td valign="middle">
                    <input type="hidden" id="count" value=10>
                    <input type='hidden' id="myrecipe" value='{{ $myrecipe }}'>
                    <input type='hidden' id="keyword" value='{{ $keyword }}'>
                    <input type='hidden' id="clear" value='{{ $clear }}'>
                    <input type='hidden' id="category_id" value='{{ $category_id }}'>
                    <input type='hidden' id="date" value='{{ $date }}'>
                    <input class="search" type="date" name='date' placeholder="" class=''>
                    <input type="submit" value="検索">
                    <input type="submit" value="クリア" name='param'>
                </td>
            </tr>
        </form>
    </table>
    <p>日付を選択してください。</p>
    <form>
        <input type="date" value='{{ date("Y-m-d") }}' name='date'>
        <div id="register-record" class="foods">
            @foreach($recipes as $key => $recipe)
            <div class="food">
                <div class="food-main">
                    <div class="food-image">
                        <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->image }}" class="">
                    </div>
                    <div class="food-info">
                        <div class="info-container">
                            <div class="mb-2 hide">
                                {{ $recipe->name }} 
                            </div>
                                <table class="food-table">
                                    <tr class="text-right">
                                        <td height="1rem" width="68">エネルギー：</td>
                                        <td>{{ $recipe->energy }}kcal</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td height="1rem" width="68">炭水化物：</td>
                                        <td>{{ $recipe->carbohydrate }}g</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td width="68">タンパク質：</td>
                                        <td>{{ $recipe->protain }}g</td>
                                    </tr>
                                    <tr class="text-right">
                                        <td width="68">脂質：</td>
                                        <td>{{ $recipe->fat }}g</td>
                                    </tr>
                                </table>
                        </div>
                    </div>
                </div>
                <div class="food-submit">
                    <input type="submit" value='登録' formaction="{{ route('record.register.get', ['id' => $recipe->id]) }}" class='register-button'>
                    <a href="{{ route('recipe.detail', [$recipe->id]) }}">詳細</a>
                </div>
                @if($myrecipe_judge[$key])
                <div class="ellipse"><p>Myレシピ</p></div>
                @endif
            </div>
            @endforeach
        </div>
    </form>



</div>

@endsection