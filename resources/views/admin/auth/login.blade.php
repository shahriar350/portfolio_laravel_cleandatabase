<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-light">
<div class="container-md">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="card">
                <div class="card-header">
                    <p class="h4">Admin login panel</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Enter your email</label>
                            <input id="email" class="form-control" type="email" placeholder="Your email" name="email" required>
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Enter your Password</label>
                            <input required id="password" class="form-control" type="password" placeholder="Your password" name="password">
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                    </form>
                </div>
                @if (session()->has('error_message'))
                    <div class="card-footer">
                        <p class="alert alert-danger">{{ session()->get('error_message') }}</p>
                    </div>
                @endif


            </div>
        </div>
    </div>
</div>
</body>
</html>
