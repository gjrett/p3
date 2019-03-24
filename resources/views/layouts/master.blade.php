

<!doctype html>
<html lang='en'>
<head>
    <title>Greg's Website</title>
    <meta charset='utf-8'>

    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css'
          rel='stylesheet'
          integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO'
          crossorigin='anonymous'>

    <link href='/css/app.css' rel='stylesheet'>
    @yield('head')
</head>
<body background='/images/stars3.png'>

<header>
    <!-- <a href='/'><img src='/images/zodiac-wheel.jpg' id='logo' alt='BirthDate Logo'></a> -->
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