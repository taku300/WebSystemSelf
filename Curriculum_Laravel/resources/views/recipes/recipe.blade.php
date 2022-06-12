@extends('layouts/layout')
@section('content')

<div class="container">
    <div class="">
        <button type="button" class="btn search-btn" onclick="location.href='{{ route('recipe', ['myrecipe' => 'myrecipe']) }}'">Myレシピ</button>
    </div>
    <table class="mt-1 mb-3">
        <form action="{{ route('recipe') }}" method="get">
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
                    <input type="hidden" id="judge2" value=2>
                    <input type="hidden" id="count" value=10>
                    <input type='hidden' id="myrecipe" value='{{ $myrecipe }}'>
                    <input type='hidden' id="keyword" value='{{ $keyword }}'>
                    <input type='hidden' id="clear" value='{{ $clear }}'>
                    <input type='hidden' id="category_id" value='{{ $category_id }}'>
                    <input type='hidden' id="date" value='{{ $date }}'>
                    <input class="search" type="date" name='date' placeholder="" class=''>
                    <input type="submit" value="検索">
                    <input type="submit" value="クリア" name='param' formaction="{{ route('recipe') }}">
                </td>
            </tr>
        </form>
    </table>


    <input type="hidden" id="count" value=10>
    <div id="recipes" class="foods">
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
                @if($myrecipe_judge[$key])
                <a href="{{ route('create.session', [$recipe->id]) }}">編集</a>
                <a href="{{ route('recipe.destory', [$recipe->id]) }}">消去</a>
                @endif
                <a href="{{ route('recipe.detail', [$recipe->id]) }}">詳細</a>
                <a href="https://twitter.com/share?text=栄養計算サイトからレシピ紹介！！%0aレシピ名：{{ $recipe->name }}%0aエネルギー：{{ $recipe->energy }}kcal%0a炭水化物：{{ $recipe->carbohydrate }}g%0aタンパク質：{{ $recipe->protain }}g%0a脂質：{{ $recipe->fat }}g%0aコメント：{{ $recipe->memo }}%0a&hashtags=栄養計算サイト"><i class="fab fa-twitter"></i></a>
                <div class="like-box">
                    @if(!$login_user_like[$key])
                    <!-- いいねされてないとき -->
                    <i id = "{{ $recipe->id }}" class="{{ 'fas fa-heart like like-' . $recipe->id }}"></i>
                    @else
                    <!-- いいねされているとき -->
                    <i id = "{{ $recipe->id }}" class="{{ 'fas fa-heart like pink like-' . $recipe->id }}"></i>
                    @endif
                    <p class="likes-count likes-count-{{ $recipe->id }}">{{ $like_counts[$key] }}</p>
                </div>
            </div>
            @if($myrecipe_judge[$key])
            <div class="ellipse"><p>Myレシピ</p></div>
            @endif
        </div>
        @endforeach
    </div>



</div>

@endsection