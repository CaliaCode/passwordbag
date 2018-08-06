<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PasswordBag') }}</title>

    <!-- Styles -->
    <link href="{{ asset('public/css/login.css') }}" rel="stylesheet">
    <style>
        html,body{
            height: 100%;
            min-height: 100%;
        }
        body{
            background-image: url('{{ asset('public/img/auth/login-background.jpeg') }}');
            background-position: center center;
            background-size: cover;
        }
        .container{
            height: 100%;
            display: table;
        }
        .row{
            display: table-cell;
            vertical-align: middle;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

    @yield('content')

    <!-- Scripts -->
    <script src="{{  asset('public/js/login.js') }}"></script>

    @stack('scripts')
</body>
</html>
