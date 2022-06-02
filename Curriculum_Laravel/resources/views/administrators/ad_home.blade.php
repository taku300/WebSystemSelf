@extends('layouts/layout')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between ">
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
        <button type="button" class="btn search-btn" onclick="location.href='/food'">新規食材登録</button>
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
    <div class="foods">
        @foreach($foods as $food)
        <div class="food">
            <div class="food-main">
                <div class="food-image">
                    <img src="{{ asset($food->image) }}" alt="{{ $food->image }}" class="">
                </div>
                <div class="food-info">
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
                <a href="{{ route('food.edit', [$food->id]) }}">編集</a>
                <a href="{{ route('food.destory', [$food->id]) }}">消去</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection