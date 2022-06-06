@extends('layouts/layout')
@section('content')

<div class="container">
    <div class="">
        <button type="button" class="btn search-btn" onclick="location.href='{{ route('recipe', ['myrecipe' => 'myrecipe']) }}'">Myレシピ</button>
    </div>
    <table class="mt-1 mb-3"　>
        <th>
            <td width="80" class="text-right">
                <div class="search-logo">
                    食材名：
                </div>
            </td>
            <td valign="middle">
                <form action="{{ route('recipe') }}" method="get">
                    <input class="search" type="search" name='keyword' placeholder="キーワードを入力" >
                    <input type="submit"　value="検索">
                    <input type="submit" value="クリア" name='param' formaction="{{ route('recipe') }}">
                </form>
            </td>
        </th>
    </table>
    <div class="foods">
        @foreach($recipes as $recipe)
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
                <a href="{{ route('recipe.detail', [$recipe->id]) }}">詳細</a>
                <a href="{{ route('recipe.edit', [$recipe->id]) }}">編集</a>
                <a href="{{ route('recipe.destory', [$recipe->id]) }}">消去</a>
                <a href="{{ route('tweet', [$recipe->id]) }}"><i class="fab fa-twitter"></i></a>
                <div class="like-box">
                    @if(!$likes->where('user_id', '=', Auth::user()->id)->where('recipe_id', '=', $recipe->id)->count() > 0)
                    <!-- いいねされてないとき -->
                    <i id = "{{ $recipe->id }}" class="{{ 'fas fa-heart like like-' . $recipe->id }}"></i>
                    @else
                    <!-- いいねされているとき -->
                    <i id = "{{ $recipe->id }}" class="{{ 'fas fa-heart like pink like-' . $recipe->id }}"></i>
                    @endif
                    <p class="likes-count likes-count-{{ $recipe->id }}">{{ $likes->where('recipe_id', '=', $recipe->id)->count() }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection