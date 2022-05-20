<!doctype html>
<!-- configファイルの中のapp.phpのLocaleを取得 -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- ウィンドウの幅をデバイスの幅に -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF(Cross-site request forgery) Token -->
    <!-- セキュリティ対策 -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ヘルパ関数configでappのnameを取得 -->
    <title>{{ config('app.name', '栄養計算サイト') }}</title>

    <!-- Scripts -->
    <!-- assetはpublicファイルから呼び出ヘルパ関数 bootstrapの読み込み（js）-->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rels="stylesheet">

    <!-- Styles bootstrapの読み込み（style）-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('stylesheet')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    栄養計算サイト
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="my-navbar-control">
                <!-- @if(Auth::check()) -->
                    <!-- <span class="my-navbar-item">{{ Auth::user()->name }}</span> -->
                    <span class="my-navbar-item">takuma</span>
                    /
                    <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!-- logoutの処理をキャンセルしてlogout-formの処理を実行 -->
                    <!-- addEventListener('イベント'　イベントリスナー） -->
                    <script>
                        document.getElementById('logout').addEventListener('click', function(event) {
                        event.preventDefault();
                        document.getElementById('logout-form').submit();
                        });
                    </script>
                <!-- @else -->
                    <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
                    /
                    <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
                <!-- @endif -->
            </div>
        </nav>
        @yield('content')
    </div>
</body>

</html>