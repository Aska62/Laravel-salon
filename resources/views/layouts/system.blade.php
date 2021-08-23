<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>みんなのサロン</title>
    <meta name="robots" content="noindex" />
    <!-- for responsive -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- bootstrap -->
    <link href="/assets/admin-lte/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/admin-lte/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- adminLTE style -->
    <link href="/assets/admin-lte/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/admin-lte/dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="header system-header">
        <a class="header__link system_header-left" href="{{route('user.home')}}">
            ユーザーの方
        </a>
        <a class="header__link system_header-left" href="{{ route('owner.home')}}">
            オーナーの方
        </a>
        <a class="header__logo system-header-logo" href="{{route('user.home')}}">
            <h1 class="logo_main">みんなのサロン</h1>
            <p class="logo_sub">Online Salons</p>
        </a>
        <a class="header__link system_header-right" href="{{route('system.top')}}">
            オーナー一覧
        </a>
        <a class="header__link system_header-right" href="{{route('system.users')}}">
            ユーザー一覧
        </a>
    </header><!-- end header -->

    @yield('content')

    <!-- フッター -->
    <footer class="footer">
        <strong class="copyright">Copyright &copy; ASKA 2021</strong>, All rights reserved.
    </footer><!-- end footer -->
        <!-- JS -->
        <!-- jquery -->
        <script src="/assets/admin-lte/plugins/jQuery/jQuery-2.2.0.min.js" type="text/javascript"></script>
        <!-- bootstrap -->
        <script src="/assets/admin-lte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- adminLTE -->
        <script src="/assets/admin-lte/dist/js/app.min.js" type="text/javascript"></script>
        <script src="{{ asset('script/index.js') }}" type="text/javascript"></script>
        @yield('script')
    </body>
</html>
