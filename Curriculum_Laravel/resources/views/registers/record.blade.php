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
        <table border="2" width="100%" align="center" class="barance_table1">
            <tr>
                <th>レシピ名</th>
                <th>エネルギー</th>
                <th>炭水化物</th>
                <th>タンパク質</th>
                <th>脂質</th>
            </tr>
            <tr>
                <td>a</td>
                <td>a</td>
                <td>a</td>
                <td>a</td>
                <td>a</td>
            </tr>
            <tr>
                <td>合計</td>
                <td >a</td>
                <td>a</td>
                <td>a</td>
                <td>a</td>
            </tr>
        </table>
        <h3 class='ttl'>アドバイス</h3>
        <div class="p-2 border border-2 border-secondary rounded rounded-3 ">
            <p>a</p>
        </div>
    </div>
@endsection