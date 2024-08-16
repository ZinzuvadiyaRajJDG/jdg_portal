@php
$name = 'teams';
@endphp
@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
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
                        Update Team
                    </h2>
                </div>
                <form action="{{ route('teams.update',$user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 lg:col-span-6">
                            <!-- BEGIN: Form Layout -->
                            <div class="intro-y box p-5">
                                <div>
                                    <label for="crud-form-1" class="form-label">Employee Name</label>
                                    <input id="crud-form-1" type="text" name="name" class="form-control w-full" placeholder="Enter Name" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="crud-form-1" class="form-label">Employee Email</label>
                                    <input id="crud-form-1" type="text" name="email" class="form-control w-full" placeholder="Enter Email" value="{{ old('email',$user->email) }}">
                                    @error('email')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="number" class="form-label">Employee Contact No.</label>
                                    <input id="number" type="text" name="number" class="form-control w-full" placeholder="Enter Contact No." value="{{ old('number',$user->number) }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" value="{{ old('number') }}">
                                    @error('number')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>    
                                <div class="mt-3">
                                    <label for="crud-form-1" class="form-label">Birthdate</label>
                                    <input id="crud-form-1" type="date" class="form-control w-full" name="birthdate" placeholder="Enter Birthdate" value="{{ old('birthdate',$user->birthdate) }}">
                                    @error('birthdate')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="crud-form-3" class="form-label">Position</label>
                                    <div class="input-group">
                                        <input id="crud-form-3" type="text" name="position" class="form-control" placeholder="Enter Position" aria-describedby="input-group-1" value="{{ old('position',$user->position) }}">
                                    </div>
                                    @error('position')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="crud-form-4" class="form-label">Joining Date</label>
                                    <div class="input-group">
                                        <input id="crud-form-4" type="date" class="form-control" name="joining_date" placeholder="Enter Joining Date" value="{{ old('joining_date',$user->joining_date) }}"  aria-describedby="input-group-2">
                                    </div>
                                    @error('joining_date')
                                        <span class="error_msg">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <label for="shift_time" class="form-label">Shift Time </label>
                                    <div class="mt-2">
                                        <input id="shift_time" type="time" class="form-control" name="shift_time" aria-describedby="input-group-5" value="{{ old('shift_time',$user->shift_time) }}">
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
                                                <input type="text" class="form-control" name="city" placeholder="Enter City" value="{{ old('city',$user->city) }}" aria-describedby="input-group-3">
                                            </div>
                                            @error('city')
                                            <span class="error_msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <label for="state" class="form-label">State</label>
                                            <div class="input-group sm:mt-0">
                                                <input type="text" class="form-control" name="state" placeholder="Enter State" value="{{ old('state',$user->state) }}" aria-describedby="input-group-4">
                                            </div>
                                            @error('state')
                                            <span class="error_msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <label for="country" class="form-label">Country</label>
                                            <div class="input-group sm:mt-0">
                                                <input type="text" class="form-control" name="country" placeholder="Enter Country" value="{{ old('country',$user->country) }}" aria-describedby="input-group-5">
                                            </div>
                                            @error('country')
                                            <span class="error_msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label>Zip Code</label>
                                    <div class="mt-2">
                                        <input type="text" class="form-control" name="zip_code" placeholder="Enter Zip Code" value="{{ old('zip_code',$user->zip_code) }}" aria-describedby="input-group-5">
                                        @error('zip_code')
                                            <span class="error_msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <label>Address</label>
                                    <div class="mt-2">
                                        <textarea name="address" class="form-control" id="address" rows="4" cols="50" placeholder="Enter your address here">{{ old('address',$user->address) }}</textarea>
                                        @error('address')
                                            <span class="error_msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="mt-3">
                                    <label>Roles</label>
                                    <div class="mt-2">
                                        <select name="roles" class="form-control capitalize" >
                                            @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ (in_array($role, $user->roles->pluck('name')->toArray()))? "selected" : "" }}>{{ $role }}</option>
                                        @endforeach
                                        
                                        </select>
                                        @error('roles')
                                            <span class="error_msg">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <label class="mt-3">Password</label>
                                <div class="input-group mt-3">
                                    <input class="form-control w-full" type="password" name="password" autocomplete="current-password" id="password" >
                                    <i class="fa fa-eye" id="togglePassword" onclick="togglePasswordVisibility()" style="margin-top: 12px; margin-left: -30; z-index: 100;"></i>
                                </div>
                                @error('password')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                                
                            </div>
                            <!-- END: Form Layout -->
                        </div>

                        <div class="intro-y col-span-12 lg:col-span-6">
                            <div class="intro-y box p-5">
                                <form action="{{ route('teams.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                        
                                    <div class="mt-3">
                                        <label for="roles" class="form-label">Roles</label>
                                        <div class="grid grid-cols-12 gap-6">
                                            @foreach($roles as $role)
                                            <div class="intro-y col-span-6 xl:col-span-3">
                                                <div class="form-check">
                                                    <input type="radio" name="roles" value="{{ $role }}" class="form-check-input role-radio" id="role-{{ $loop->index }}"
                                                    data-permissions='@json($rolePermissions[$role] ?? [])'
                                                    {{ in_array($role, $userRoles) ? "checked" : "" }}>
                                                    <label class="form-check-label capitalize" for="role-{{ $loop->index }}">{{ $role }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                            @error('roles')
                                                <span class="error_msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                        
                                    <div class="form-group mt-3">
                                        <label for="permission" class="form-label">Permission:</label>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
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
                                                            <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input permission-checkbox" id="permission-{{ $value->id }}" @if($user->hasPermissionTo($value->name)) checked @endif>
                                                            <span class="ml-2">{{ $value->name }}</span>
                                                        </label>
                                                    @endif
                                                @endforeach
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="text-right mt-5">
                                        <button type="button" class="btn btn-outline-secondary w-24 mr-1" id="cancelButton">Cancel</button>
                                        <button type="submit" class="btn btn-primary w-24">Update</button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get a reference to the cancel button
    const cancelButton = document.getElementById('cancelButton');

    // Add a click event listener to the cancel button
    cancelButton.addEventListener('click', function () {
      // Implement your desired cancel logic here.
      // For example, you can redirect to another page or close a modal.

      // Example: Redirect to the homepage
      window.location.href = '/users';
    });
  });
</script>
<script>
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

    // Function to update permissions based on selected role
    function updatePermissions(selectedPermissions) {
        // Uncheck all permission checkboxes first
        permissionCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        // Check the permissions associated with the selected role
        selectedPermissions.forEach(permissionId => {
            const checkbox = document.getElementById('permission-' + permissionId);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }

    // Add event listener to each role radio button
    roleRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedPermissions = JSON.parse(this.getAttribute('data-permissions'));
            updatePermissions(selectedPermissions);
        });
    });

   
});

</script>

<!-- <script>
     // Trigger change event for the initially selected role
    // const checkedRoleRadio = document.querySelector('.role-radio:checked');
    // if (checkedRoleRadio) {
    //     const initialPermissions = JSON.parse(checkedRoleRadio.getAttribute('data-permissions'));
    //     updatePermissions(initialPermissions);
    // }
</script> -->
@endsection