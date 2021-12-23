<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ mix('js/test.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/ajax.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#toggleTarget" aria-controls="toggleTarget" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon ml-auto"></span>
            </button>
            @if (!empty(session('company_code')) && !empty(session('admin_code')))
                <div class="collapse navbar-collapse" id="toggleTarget">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ml-auto">
                            <a href="/admin/home" class="a-black mx-2">ホーム画面へ</a>
                        </li>
                        <li class="nav-item ml-auto">
                            <a href="/admin/logout" class="a-black mx-2">ログアウト</a>
                        </li>
                    </ul>
                </div>
            @elseif (!empty(session('company_code')) && !empty(session('employee_code')))
                <div class="collapse navbar-collapse" id="toggleTarget">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ml-auto">
                            <a href="/employee/home" class="a-black mx-2">ホーム画面へ</a>
                        </li>
                        <li class="nav-item ml-auto">
                            <a href="/employee/logout" class="a-black mx-2">ログアウト</a>
                        </li>
                    </ul>
                </div>
            @elseif (!empty(session('company_code')) && !empty(session('company_name')))
                <div class="collapse navbar-collapse" id="toggleTarget">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ml-auto">
                            <a href="/company/logout" class="a-black mx-2">ログアウト</a>
                        </li>
                    </ul>
                </div>
            @else
                <div class="collapse navbar-collapse" id="toggleTarget">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item ml-auto">
                            <a href="/admin/login" class="a-black mx-2">管理者用ログイン画面</a>
                        </li>
                        <li class="nav-item ml-auto">
                            <a href="/employee/login" class="a-black mx-2">従業員用ログイン画面</a>
                        </li>
                    </ul>
                </div>
            @endif
        </nav>

        <main class="py-4">
            @include('components.toastr')
            @yield('content')
        </main>
    </div>
</body>
</html>
