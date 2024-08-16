<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('assets/user/images/BLACK-LOGOpng.png') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Just Digital Gurus Portal">
        <meta name="keywords" content="Just Digital Gurus Portal">
        <meta name="author" content="LEFT4CODE">
        <title>JDG Portal Design</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('assets/user/css/webpage.css') }}" />
        
        <style>
             .bg-banner { 
                background-image: url('{{ url("public/images/banners/". $banner->banner_image) }}');
                background-repeat: no-repeat;
                height: 100vh;
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="bg-black">


       <!-- Hero 5 - Bootstrap Brain Component -->
       <section class="bsb-hero-5 px-3 bsb-overlay relative bg-banner">
            <nav class="navbar navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('assets/user/images/logo.png') }}" alt="" width="150px">
                    </a>
                </div>
            </nav>
            <div class="container d-flex flex-column justify-content-center h-50">
                <div class="row justify-content-center align-items-center flex-column">
                    <div class="col-sm-12 col-lg-6">
                        <form class="d-flex flex-column justify-content-center position-relative glassmorphism" method="POST" action="{{ url('/login') }}">
                            @csrf
                            <h3 class="text-center mb-4">Login</h3>
                            <input type="text" class="form-control form-control-lg shadow-lg mb-3" placeholder="Email" name="email" value="{{ old('email') }}" autofocus>
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-lg shadow-lg mb-3" placeholder="Password" name="password" id="password">
                                <span class="position-absolute" style="top: 12px; right: 15px;" onclick="togglePassword()">
                                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <button class="btn btn-lg btn-dark mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </section>
    

        @if(count($iconlinks) > 0)
            <section class="section-space">
                <div class="container">
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        @foreach($iconlinks as $iconlink)
                            <a href="{{ $iconlink->link }}"><img src="{{ url("public/images/linkicons/". $iconlink->banner_image) }}" alt="" width="100px" height="100px"></a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="section-space">
            <div class="py-4">
                <div class="container ">
                    <h2 class="fw-bold text-center">🎯
                        <span class="gradient-text"> 
                            <span>N</span><span>o</span><span>t</span><span>i</span><span>c</span><span>e</span>
                            <span>B</span><span>o</span><span>a</span><span>r</span><span>d</span>    
                        </span>
                    </h2>
                </div>
            </div>
        </section>
        
        <section class="section-space">
            <div class="container">
                <div class="text-white">
                    {!! $notice_board->notice !!}

                </div>
            </div>
        </section>
        
        <section class="section-space">
            <div class="py-4">
                <div class="container ">
                    <h2 class="fw-bold text-center">
                        <span class="gradient-text"> 
                            <span>Q</span><span>u</span><span>i</span><span>c</span><span>k</span>
                            <span>L</span><span>i</span><span>n</span><span>k</span>    
                        </span>
                    </h2>
                </div>
            </div>
        </section>

        @if(count($quicklinks) > 0)
            <section class="section-space">
                <div class="container">
                    <div class="row">
                        @foreach($quicklinks as $quicklink)
                            <a href="{{ $quicklink->link }}" class="text-decoration-none text-dark">
                                <div class="col-md-4 mb-3">
                                    <div class="card text-bg-dark h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $quicklink->name }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="section-space">
            <div class="py-4">
                <div class="container ">
                    <h2 class="fw-bold text-center">
                        <span class="gradient-text"> 
                            <span>C</span><span>a</span><span>l</span><span>e</span><span>n</span><span>d</span><span>a</span><span>r</span>
                        </span>
                    </h2>
                </div>
            </div>
        </section>

        <section class="section-space mb-5">
            <div class="container">
                <iframe src="https://calendar.google.com/calendar/embed?src=92922dd3519e789164f8ce05f3cc68eb509c4e13e89dceb322fd9647e9929617%40group.calendar.google.com&ctz=Asia%2FKolkata" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
            </div>
        </section>

    </body>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

    </script>
</html>