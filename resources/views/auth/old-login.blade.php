@extends('layouts.auth')

@section('content')
    <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- BEGIN: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                    <a href="" class="-intro-x flex items-center pt-5">
                        <img alt="Rubick Tailwind HTML Admin Template" class="w-20" style="width: 10rem;" src="{{ asset('assets/user/images/Just Digital Guru.png') }}">
                        <!-- <span class="text-white text-lg ml-3"> Ru<span class="font-medium">bick</span> </span> -->
                    </a>
                    <div class="my-auto">
                        <img alt="Rubick Tailwind HTML Admin Template" class="-intro-x w-1/2 -mt-16" src="{{ asset('assets/user/images/illustration.svg') }}">
                        <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                            Welcome to Just Digital Gurus
                        </div>
                        <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Where Your Digital Odyssey Begins!</div>
                    </div>
                </div>
                <!-- END: Login Info -->
                <!-- BEGIN: Login Form -->
                <div class="flex items-center justify-center w-full">

                <form method="POST" action="{{ url('/login') }}" class="mt-5">
                {{-- {{ csrf_field() }} --}}
                @csrf
                <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0" style="height: 80vh;">
                    <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                        <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                            Sign In
                        </h2>
                        <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">Welcome to Just Digital Gurus - Where Your Digital Odyssey Begins!</div>
                        <div class="intro-x mt-8 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Email" aria-describedby="emailHelp" name="email" value="{{ old('email') }}" autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <div class="relative mt-4">
                                <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Password" name="password" id="password">
                                <span class="absolute inset-y-0 flex items-center pr-3 cursor-pointer z-50" style="right: 20px;" onclick="togglePassword()">
                                    <i id="togglePasswordIcon" class="w-5 h-5" data-feather="eye"></i>
                                </span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {{-- <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Password" name="password" id="exampleInputPassword1">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif --}}
                        </div>
                        <div class="intro-x flex items-center text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit">Login</button>
                            </div>
                            <a href="{{ url('forgot-password') }}">Forgot Password?</a> 
                        </div>
                    </div>
                </div>
                </form>
                <!-- END: Login Form -->
            </div>

@endsection


@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        feather.replace(); // Ensure Feather icons are replaced when the page loads
    });

    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var passwordIcon = document.getElementById("togglePasswordIcon");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.setAttribute("data-feather", "eye-off");
        } else {
            passwordInput.type = "password";
            passwordIcon.setAttribute("data-feather", "eye");
        }

        feather.replace(); // Re-render the Feather icons to reflect the changes
    }
</script>
@endsection