<html lang="en" class="{{ session('dark_mode') ? 'dark' : '' }}">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('assets/user/images/BLACK-LOGOpng.png') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Just Digital Gurus Portal">
        <meta name="keywords" content="Just Digital Gurus Portal">
        <meta name="author" content="LEFT4CODE">
        <title>Login - Just Digital Gurus</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('assets/user/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
<body class="login">

    @yield('content')

    <!-- Scripts -->
    <script src="{{ asset('assets/user/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    @yield('script')

</body>
</html>
