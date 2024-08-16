@php
$name = "profile";
@endphp

@extends('layouts.app')

@section('content')

<style>
    .error_msg {
        color: #dc3645;
        font-weight: 300;
    }
</style>


<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Edit Profile
    </h2>
</div>
<form action="{{ url('update_profile') }}" method="POST" enctype="multipart/form-data">
    @csrf <!-- Add CSRF protection -->
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
                    <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Enter Email" value="{{ $user->email}}" disabled>
                    {{-- <input id="crud-form-1" type="hidden" name="email" class="form-control w-full" placeholder="Enter Email" value="{{ $user->email}}" disabled> --}}
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
                {{-- <div class="mt-3"> --}}
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
                            <div class="input-group  sm:mt-0">
                                <input type="text" class="form-control" name="country" placeholder="Enter Country" value="{{ old('country',$user->country) }}" aria-describedby="input-group-5">
                            </div>
                            @error('country')
                            <span class="error_msg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                {{-- </div> --}}
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
                <div class="text-right mt-5">
                    <button type="button" class="btn btn-outline-secondary w-24 mr-1" id="cancelButton">Cancel</button>
                    <button type="submit" class="btn btn-primary w-24">Update</button>
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
@endsection