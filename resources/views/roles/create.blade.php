@extends('layouts.app')


@section('content')
@php
$name = 'roles';
@endphp
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Add Roles</h2>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger mt-4">
        <strong>Whoops!</strong> Something went wrong.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('roles.store') }}">
    @csrf
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-9">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input id="name" type="text" name="name" class="form-control w-full" placeholder="Enter Roles">
                </div>
                
                <div class="form-group mt-3">
    <label for="permission" class="form-label">Permission:</label>
    <br/>
    <div class="grid grid-cols-12 gap-6 mt-5">
        @php
            $processedPermissions = [];
        @endphp

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Employee</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:employee)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Team</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:team)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Role</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:role)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Attendance</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:attendance)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
            <h2 class="text-md font-medium mr-auto mt-3">Manage KPI Points</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:kpi)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Holiday</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:holiday)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Leave</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:leave)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Salary</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:salary)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach

            <h2 class="text-md font-medium mr-auto">Manage Careers</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:careers)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
            <h2 class="text-md font-medium mr-auto">Manage Webpage</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:webpage)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Overtime</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:overtime)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

        <div class="intro-y col-span-12 md:col-span-3">
            <h2 class="text-md font-medium mr-auto">Manage Dashboard</h2>
            @foreach($permission as $value)
                @if(!in_array($value->name, $processedPermissions) && preg_match('/(?:dashboard)/', $value->name))
                    @php
                        $processedPermissions[] = $value->name;
                    @endphp
                    <label class="flex items-center">
                        <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name form-check-input">
                        <span class="ml-2">{{ $value->name }}</span>
                    </label>
                @endif
            @endforeach
        </div>

    </div>
</div>

                <div class="text-right mt-5">
                    <button type="button" id="cancelButton" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Save</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
</form>
@endsection