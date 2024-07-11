<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1">
    <title>Вход в окружение RBRU</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <!--<link rel="stylesheet" href="/appl/css/bootstrap-4.4.1-dist/css/bootstrap.min.css">-->
</head>
<style>
    html,
    body {
        height: 100%;
    }
    body {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -ms-flex-pack: center;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
        /* border: 1px dotted darkblue; */
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
<body class="text-center">
<form class="form-signin" method="POST">
    @csrf
    <input type="text" value="" id="username" name="username" class="form-control" placeholder="Samoware Account" required autofocus>
    <hr>
    <input type="password" id="password" class="form-control" name="password" placeholder="Samoware Password" required><span style="color:red;font-weight:bold;">{{ ((isset($pwd) && $pwd=='bad')?'Wrong UserName or Password!':'') }}</span>
    <hr>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; IT {{ Date('Y') }}</p>
    <input type=hidden value="" name="forwardto" id="forwardto">
</form>
</body>
</html>
