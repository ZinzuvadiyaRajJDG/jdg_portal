@php
$name = 'profile';
@endphp
@extends('layouts.app')
@section('content')
<div class="intro-y flex items-center mt-8">
                    <h2 class="text-lg font-medium mr-auto">
                        Profile
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-12 mt-5">
                    <!-- BEGIN: Profile Menu -->
                    <div class="col-span-12 lg:col-span-12 xxl:col-span-6 flex lg:block flex-col-reverse">
                        <div class="intro-y box mt-5 lg:mt-0">
                            <div class="relative flex items-center p-5">

                                <div class="ml-4 mr-auto">
                                    <div class="font-medium text-base">{{ $user->name }}</div>
                                    <div class="text-gray-600">{{ $user->position }}</div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Personal Information </a>
                                <div class="grid grid-cols-12 gap-12 mt-5">
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">

                                          <div class="font-medium text-base mt-3">Name :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->name }}</div>
                                        
                                        <div class="font-medium text-base mt-3">Email :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->email }}</div>

                                        <div class="font-medium text-base mt-3">Contact No. :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->number }}</div>
                                        
                                        <div class="font-medium text-base mt-3">Birthdate :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->birthdate }}</div>

                                        <div class="font-medium text-base mt-3">Role :- </div>
                                        <div class="text-gray-600 mt-1">
                                            @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif   
                                        </div>

                                        <div class="font-medium text-base mt-3">Address :- </div>
                                        <div  class="text-gray-600 mt-1">{{ $user->address }}</div>
                                    </div>
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">

                                        <div class="font-medium text-base mt-3">Position :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->position }}</div>
                                        
                                        <div class="font-medium text-base mt-3">Joining  Date :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->joining_date }}</div>
                                        
                                        <div class="font-medium text-base mt-3">City :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->city }}</div>

                                        <div class="font-medium text-base mt-3">State :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->state }}</div>

                                        <div class="font-medium text-base mt-3">Country :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->country }}</div>

                                        <div class="font-medium text-base mt-3">Zip Code :- </div>
                                        <div class="text-gray-600 mt-1">{{ $user->zip_code }}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Saved Credit Cards </a>
                                <a class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Social Networks </a>
                                <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Tax Information </a>
                            </div> -->
                            <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                                <!-- <button type="button" class="btn btn-primary py-1 px-2">New Group</button> -->
                                <a type="button" href="{{ url('edit_profile') }}" class="btn btn-outline-secondary py-1 px-2 ml-auto">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                    <!-- END: Profile Menu -->
                        </div>
                    </div>
                </div>
@endsection
@section('js')
<script>
@if(session('success'))
    swal({
        title: "{{ session('success') }}",
        icon: "success",
        button: "OK",
    })
@endif
</script>
<script>
@if(session('error'))
    swal({
        title: "{{ session('error') }}",
        icon: "error",
        button: "OK",
    })
@endif
</script>
@endsection
