@extends('layout/layout')
@section('content')
    <main>
        <div class="container px-5">
            <div class="home_logo">
                <img src="/image/home_logo.png" alt="">
            </div>
            <h3 class='ttl'>目標値(１日あたり)</h3>
            <table border="2" width="100%" align="center" class="home_table1">
                <tr>
                    <th>目標体重</th>
                    <th>エネルギー</th>
                    <th>炭水化物</th>
                    <th>タンパク質</th>
                    <th>脂質</th>
                </tr>
                <tr>
                    <td>{{ $user['weight'] }}kg</td>
                    <td>{{ $param['energy'] }}kcal</td>
                    <td>{{ $param['carbohydrate_lower'] }}g~{{ $param['carbohydrate_upper'] }}g</td>
                    <td>{{ $param['protain_lower'] }}g~{{ $param['protain_upper'] }}g</td>
                    <td>{{ $param['fat_lower'] }}g~{{ $param['fat_upper'] }}g</td>
                </tr>
            </table>
            <p>※設定した年齢、性別、身長、目標体重から必要なエネルギーを計算しています。</p>
            <p>&emsp;またそれに基づいた炭水化物、タンパク質、脂質の栄養バランスを表示しています。</p>
            <p>&emsp;この栄養バランスに近づくような食事を心がけましょう。</p>
            <h3 class='ttl'>今日の食事</h3>
            <table border="2" width="100%" align="center" class="home_table1">
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
            <h3 class='ttl'>このサイトについて</h3>
            <h3 class='ttl'>機能</h3>
            <h3 class='ttl'>工夫した点</h3>


        </div>
    </main>
@endsection