@extends('layouts/layout')
@section('content')
    <div class="container">
        <h3 class='ttl'>目標値(１日あたり)</h3>
        <table border="2" width="100%" align="center" class="barance_table1">
            <tr>
                <th>目標体重</th>
                <th>エネルギー</th>
                <th>炭水化物</th>
                <th>タンパク質</th>
                <th>脂質</th>
            </tr>
            <tr>
                <td>{{ $user['target_weight'] }}kg</td>
                <td>{{ $target['energy'] }}kcal</td>
                <td>{{ $target['carbohydrate_lower'] }}g~{{ $target['carbohydrate_upper'] }}g</td>
                <td>{{ $target['protain_lower'] }}g~{{ $target['protain_upper'] }}g</td>
                <td>{{ $target['fat_lower'] }}g~{{ $target['fat_upper'] }}g</td>
            </tr>
        </table>
        <p>※設定した年齢、性別、身長、目標体重から必要なエネルギーを計算しています。</p>
        <p>&emsp;またそれに基づいた炭水化物、タンパク質、脂質の栄養バランスを表示しています。</p>
        <p>&emsp;この栄養バランスに近づくような食事を心がけましょう。</p>
        <h3 class='ttl'>今日の食事</h3>
        <div class='d-flex justify-content-between'>
            <form action="/record">
                @csrf
                <table>
                    <th>
                        <td width="190" class="text-left">
                            <div class="search-logo">
                                日付を選択してください。
                            </div>
                        </td>
                        <td>    
                            <input type="submit" value='確定'>
                        </td>
                    </th>
                </table>
                <input type="date" name='date' value='{{ $date }}'>
            </form>
            <button type="button" class="btn search-btn" onclick="location.href='/record/register'">レシピから登録</button>
        </div>
        <table border="2" width="100%" align="center" class="barance_table1 mt-4">
            <tr>
                <th>レシピ名</th>
                <th>エネルギー</th>
                <th>炭水化物</th>
                <th>タンパク質</th>
                <th>脂質</th>
                <th style="text-align: center">ー</th>
                <th style="text-align: center">ー</th>
            </tr>
            @if($recipes)
                @foreach($recipes as $key => $recipe)
                <tr>
                    <td>{{ $recipe->name }}</td>
                    <td>{{ $recipe->energy }}kcal</td>
                    <td>{{ $recipe->carbohydrate }}g</td>
                    <td>{{ $recipe->protain }}g</td>
                    <td>{{ $recipe->fat }}g</td>
                    <td><a href="{{ route('recipe.detail', [$recipe->id]) }}">詳細</a></td>     
                    <td><a href="{{ route('record.destory', [$history_key[$key]]) }}">消去</a></td>     
                </tr>
                @endforeach
                <tr>
                    <th>合計</th>
                    <th>{{ $sum['energy'] }}kcal</th>
                    <th>{{ $sum['carbohydrate'] }}g</th>
                    <th>{{ $sum['protain'] }}g</th>
                    <th>{{ $sum['fat'] }}g</th>
                    <th style="text-align: center">ー</th>
                    <th style="text-align: center">ー</th>
                </tr>
            @endif
        </table>
        <h3 class='ttl'>アドバイス</h3>
        <div class="p-2 border border-2 border-secondary rounded rounded-3 ">
            @foreach($alerts as $alert)
                <p>{{$alert}}</p>
            @endforeach
        </div>
    </div>
@endsection