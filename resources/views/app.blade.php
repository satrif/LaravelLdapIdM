<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <ul class='titler bottom-small-margin'>
            <li>Signed in as: <a class='logout_link' href='{{ route('destroy') }}' title='LogOut'>{{ $_SESSION['uName'] }}</a></li>
            <li id='rightli' class='rightli'>{{ config('app.idm_app_name') }} | Access: {{ implode(', ',$roleArr) }}</li>
        </ul>
        @switch(Route::current()->uri())
            @case('/')
                @yield('welcomePage')
                @break
            @default
                <p>empty :(</p>
                <p>{{ Route::current()->uri() }}</p>
                @break
        @endswitch
    </body>
</html>
