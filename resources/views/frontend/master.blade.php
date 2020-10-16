<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/website.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Mina&display=swap" rel="stylesheet">
    @yield('head')
</head>
<body>
    <section id="app" style="background: whitesmoke">
        <div class="container-lg">
            @yield('body')
        </div>

    </section>

<script src="{{ mix('js/app.js') }}"></script>
@yield('js')
</body>
</html>
