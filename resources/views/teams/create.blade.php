@php
    $name = 'teams';
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
        Add Teams
    </h2>
</div>

<form method="POST" action="{{ route('teams.store') }}">
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
                        @error('shift_time')
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
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="mt-3">
                    <label for="roles" class="form-label">Roles</label>
                    <div class="grid grid-cols-12 gap-6">
                        @foreach($roles as $role)
                            @if($role != 'user')
                                <div class="intr    o-y col-span-6 xl:col-span-4">
                                    <div class="form-check">
                                        <input type="radio" name="roles" value="{{ $role }}" class="form-check-input role-radio" id="role-{{ $loop->index }}"
                                        data-permissions='@json($rolePermissions[$role] ?? [])'
                                        {{ (old('roles') == $role) ? "checked" : "" }}>
                                        <label class="form-check-label capitalize" for="role-{{ $loop->index }}">{{ $role }}</label>
                                    </div>
                                </div>                          
                            @endif
                        @endforeach
                        @error('roles')
                            <span class="error_msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                

                <div class="form-group mt-3">
                    <label for="permission" class="form-label">Permission:</label>
                    <br/>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        @php
                            $processedPermissions = [];
                        @endphp
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Employee</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:employee)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Team</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:team)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Role</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:role)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Attendance</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:attendance)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                            <h2 class="text-md font-medium mr-auto mt-3">Manage KPI Points</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:kpi)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Holiday</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:holiday)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Leave</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:leave)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Salary</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:salary)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                            <h2 class="text-md font-medium mr-auto">Manage Careers</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:careers)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                            <h2 class="text-md font-medium mr-auto">Manage Webpage</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:webpage)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Overtime</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:overtime)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                        <div class="intro-y col-span-12 md:col-span-4">
                            <h2 class="text-md font-medium mr-auto">Manage Dashboard</h2>
                            @foreach($permissions as $value)
                                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:dashboard)/', $value->name))
                                    @php
                                        $processedPermissions[] = $value->name;
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}">
                                        <span class="ml-2">{{ $value->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                
                    </div>    
                </div>
                
                
            </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all role radio buttons
        const roleRadios = document.querySelectorAll('.role-radio');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

        // Add event listener to each role radio button
        roleRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                const selectedPermissions = JSON.parse(this.getAttribute('data-permissions'));

                // Uncheck all permission checkboxes first
                permissionCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Check the permissions associated with the selected role
                selectedPermissions.forEach(permissionId => {
                    document.getElementById('permission-' + permissionId).checked = true;
                });
            });
        });

        // Trigger change event for the initially selected role
        const checkedRoleRadio = document.querySelector('.role-radio:checked');
        if (checkedRoleRadio) {
            checkedRoleRadio.dispatchEvent(new Event('change'));
        }
    });
</script>

@endsection
