
<!doctype html>
<html lang='en'>
<head>
    <title>Greg's Website</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href='/css/birthday.css' rel='stylesheet'>
    @yield('head')
</head>

<body>

<header>
    <a href='/'><img src='/images/birthday_logo.png' id='logo' alt='Birthday Logo'></a>
    <div class="header">
        <div class='centered'>
            <nav>
                <ul>
                    @foreach(config('app.nav') as $link => $label)
                        <li>
                            {{-- If the current path is the same as this link, display as plain text, not a hyperlink--}}
                            @if(Request::is($link))
                                {{ $label }}
                                {{-- Otherwise, display as a hyerlink --}}
                            @else
                                <a href='/{{ $link }}'>{{ $label }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</header>

<section>
    @yield('content')
</section>

<footer>
    &copy; {{ date('Y') }}
    <a href='https://github.com/gjrett/p3'>View this project on Github</a>
</footer>

</body>
</html>