@php
    $name = 'employees';
@endphp

@extends('layouts.app')

@section('content')
<style>
    .input-with-icon {
        display: flex;
        align-items: center;
    }

    .password-input {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input input[type="password"] {
        border-radius: 0.25rem;
        padding-right: 30px; /* Make space for the eye icon */
        border: 1px solid #ccc;
    }

    .password-input i.fa-eye {
        position: absolute;
        top: 50%;
        right: 5px;
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
        Add Employee
    </h2>
</div>

<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <!-- Your Form Fields -->
                <div>
                    <label for="name" class="form-label">Employee Name</label>
                    <input id="name" type="text" name="name" class="form-control w-full" placeholder="Enter Name" value="{{ old('name') }}">
                    @error('name')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Continue with the rest of your form fields -->
                <!-- Your Form Fields -->
                <div class="mt-3">
                    <label for="email" class="form-label">Employee Email</label>
                    <input id="email" type="text" name="email" class="form-control w-full" placeholder="Enter Email" value="{{ old('email') }}">
                    @error('email')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Continue with the rest of your form fields -->

                <div class="mt-3">
                    <label for="number" class="form-label">Employee Contact No.</label>
                    <input id="number" type="text" name="number" class="form-control w-full" placeholder="Enter Contact No." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" value="{{ old('number') }}">
                    @error('number')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input id="birthdate" type="date" class="form-control w-full" name="birthdate" placeholder="Enter Birthdate" value="{{ old('birthdate') }}">
                    @error('birthdate')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="position" class="form-label">Position</label>
                    <div class="input-group">
                        <input id="position" type="text" name="position" class="form-control" placeholder="Enter Position" aria-describedby="input-group-1" value="{{ old('position') }}">
                    </div>
                    @error('position')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="joining_date" class="form-label">Joining Date</label>
                    <div class="input-group">
                        <input id="joining_date" type="date" class="form-control" name="joining_date" placeholder="Enter Joining Date"  aria-describedby="input-group-2" value="{{ old('joining_date') }}">
                    </div>
                    @error('joining_date')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                 <div class="mt-3">
                    <label for="shift_time" class="form-label">Shift Time </label>
                    <div class="mt-2">
                        <input id="shift_time" type="time" class="form-control" name="shift_time" aria-describedby="input-group-5" value="{{ old('shift_time') }}">
                        @error('zip_coshift_timede')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="mt-3">
                            <label for="city" class="form-label">City</label>
                            <div class="input-group">
                                <input id="city" type="text" class="form-control" name="city" placeholder="Enter City" aria-describedby="input-group-3" value="{{ old('city') }}">
                            </div>
                            @error('city')
                            <span class="error_msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="state" class="form-label">State</label>
                            <div class="input-group  sm:mt-0">
                                <input id="state" type="text" class="form-control" name="state" placeholder="Enter State" aria-describedby="input-group-4" value="{{ old('state') }}">
                            </div>
                            @error('state')
                            <span class="error_msg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="country" class="form-label">Country</label>
                            <div class="input-group sm:mt-0">
                                <input id="country" type="text" class="form-control" name="country" placeholder="Enter Country" aria-describedby="input-group-5" value="{{ old('country') }}">
                            </div>
                            @error('country')
                            <span class="error_msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="zip_code" class="form-label">Zip Code</label>
                    <div class="mt-2">
                        <input id="zip_code" type="text" class="form-control" name="zip_code" placeholder="Enter Zip Code" aria-describedby="input-group-5" value="{{ old('zip_code') }}">
                        @error('zip_code')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
               
                <div class="mt-3">
                    <label for="address" class="form-label">Address</label>
                    <div class="mt-2">
                        <textarea id="address" name="address" class="form-control" id="address" rows="4" cols="50" placeholder="Enter your address here">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- <div class="mt-3">
                    <label for="roles" class="form-label">Roles</label>
                    <div class="">
                        <select id="roles" name="roles" class="form-control capitalize">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option  value="{{ $role }}" {{ (old('roles') == $role)? "selected" : "" }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>      -->
                
                <div class="mt-3">
                    <label for="salary" class="form-label">Salary</label>
                    <div class="">
                        <input id="salary" type="text" class="form-control" name="salary" placeholder="Enter Salary" aria-describedby="input-group-5" value="{{ old('salary') }}">
                        @error('salary')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="password" class="form-label">Employee Password</label>
                    
                    <div class="input-group">
                        <input class="form-control w-full" id="password" type="password" name="password" autocomplete="current-password"  id="password">
                        <i class="fa fa-eye" id="togglePassword" onclick="togglePasswordVisibility()" style="margin-top: 12px; margin-left: -30; z-index: 100;}"></i>
                    </div>
                    @error('password')
                        <span class="error_msg">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Your other form fields -->

                <div class="text-right mt-5">
                    <button id="cancelButton" type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
</form>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cancelButton = document.getElementById('cancelButton');

        cancelButton.addEventListener('click', function () {
            window.location.href = '/users';
        });
    });

    function togglePasswordVisibility() {
        var passwordInput = $('#password');
        var toggleIcon = $('#togglePassword');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            toggleIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            toggleIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }
</script>
@endsection
