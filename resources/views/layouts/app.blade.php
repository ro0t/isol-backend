<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/png" href="{{asset('igw/Favicon.png')}}"/>
    <link rel="shortcut icon" type="image/png" href="{{asset('igw/Favicon.png')}}"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ísól - Igital web manager</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="{{Auth::check()?'igw':'login'}}">

    @if(Auth::check())
        @include('components.header')
        @include('components.sidebar')
    @endif

    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
