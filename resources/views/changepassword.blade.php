@php
$name = 'changepassword';
@endphp

@extends('layouts.app')

@section('content')
<style>
.password-input {
    position: relative;
}

.toggle-password {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}
.error_msg {
    color: #dc3645;
    font-weight: 300;
}
</style>
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Change Password
    </h2>
</div>
<form method="POST" action="{{ url('change-password') }}">
    @csrf <!-- Add CSRF protection -->
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div>
                    <label for="old_password" class="form-label">Old Password</label>
                    <div class="password-input">
                        <input id="old_password" type="password" name="old_password" class="form-control w-full" placeholder="Enter Old Password">
                        <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('old_password', this)"></i>
                    </div>
                    @error('old_password')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <div class="password-input">
                        <input id="new_password" type="password" name="new_password" class="form-control w-full" placeholder="Enter New Password">
                        <i class="fa fa-eye toggle-password" onclick="togglePasswordVisibility('new_password', this)"></i>
                        @error('new_password')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="text-right mt-5">
                    <button type="button" id="cancelButton" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Save</button> <!-- Change the button type to "submit" -->
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
</form>
@endsection

@section('js')

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get a reference to the cancel button
            const cancelButton = document.getElementById('cancelButton');

            // Add a click event listener to the cancel button
            cancelButton.addEventListener('click', function() {
                // Implement your desired cancel logic here.
                // For example, you can redirect to another page or close a modal.

                // Example: Redirect to the homepage
                window.location.href = '{{ url("profile") }}';
            });
        });
    </script>

<script>
function togglePasswordVisibility(inputId, icon) {
    const passwordInput = document.getElementById(inputId);

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

@if(session('success'))
<script>
    swal({
        title: "{{ session('success') }}",
        icon: "success",
        button: "OK",
    });
</script>
@endif

@if(session('error'))
<script>
    swal({
        title: "{{ session('error') }}",
        icon: "error",
        button: "OK",
    });
</script>
@endif
@endsection
