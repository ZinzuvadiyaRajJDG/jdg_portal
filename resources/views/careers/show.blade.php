@php
$name = 'careers';
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">Application Details</h2>


 <div class="grid grid-cols-12 gap-12 mt-5">
                    <!-- BEGIN: Profile Menu -->
                    <div class="col-span-12 lg:col-span-12 xxl:col-span-6 flex lg:block flex-col-reverse">
                        <div class="intro-y box mt-5 lg:mt-0">
                            <div class="relative flex items-center p-5">

                                <div class="ml-4 mr-auto">
                                    <div class="font-medium text-base">{{ $careers->first_name }} {{ $careers->last_name }}</div>
                                    <div class="text-gray-600">{{ $careers->position }}</div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Personal Information </a>
                                <div class="grid grid-cols-12 gap-12 mt-5">
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">
                                        
                                        <div class="font-medium text-base mt-3">Name :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->first_name }} {{ $careers->last_name }}</div>
                                        
                                        <div class="font-medium text-base mt-3">Phone Number :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->number }}</div> 
                                        
                                    </div>
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">
                                        
                                        <div class="font-medium text-base mt-3">Email :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->email }}</div>

                                        <div class="font-medium text-base mt-3">Address :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->address }}</div>
                                        
                                    </div>
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">

                                        <div class="font-medium text-base mt-3">Show Linkedin Profile :- <span class="text-gray-600 mt-1">
                                            <a href="{{ $careers->linkedin_url }}"> Click Here... </a>
                                        </span></div>
                                        
                                    </div>
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">
                                        <div class="font-medium text-base mt-3">Status :- </div>
                                        @if($careers->status == 'Rejected')
                                        <details>
                                            <summary>{{ $careers->status }}</summary>
                                            <p>Message : {{ $careers->rejected_message }}</p>
                                        </details>

                                        @else
                                        <div class="text-gray-600 mt-1">{{ $careers->status }}</div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" href=""> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Professional Information </a>
                                <div class="grid grid-cols-12 gap-12 mt-5">
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">
                                        
                                        <div class="font-medium text-base mt-3">Position :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->position }}</div>

                                        <div class="font-medium text-base mt-3">Experience :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->exprerience }}</div>

                                        <div class="font-medium text-base mt-3">Technical Skills :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->skills }}</div>
                                      
                                    </div>
                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 flex lg:block flex-col">

                                        <div class="font-medium text-base mt-3">References :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->reference }}</div>
                                      
                                        <div class="font-medium text-base mt-3">CTC :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->ctc }}</div>
                                      
                                        <div class="font-medium text-base mt-3">ECTC :- </div>
                                        <div class="text-gray-600 mt-1">{{ $careers->ectc }}</div>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                <a class="flex items-center text-theme-1 dark:text-theme-10 font-medium" target="_blank" href="https://careers.justdigitalgurus.com/public/{{ $careers->resume }}"> <i data-feather="activity" class="w-4 h-4 mr-2"></i> Resume </a>
                                <iframe src="https://careers.justdigitalgurus.com/public/{{ $careers->resume }}" frameborder="0" class="mt-5" width="100%" height="600px"></iframe>
                            </div>
                            <!-- <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                <a class="flex items-center mt-5" href=""> <i data-feather="box" class="w-4 h-4 mr-2"></i> Saved Credit Cards </a>
                                <a class="flex items-center mt-5" href=""> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Social Networks </a>
                                <a class="flex items-center mt-5" href=""> <i data-feather="settings" class="w-4 h-4 mr-2"></i> Tax Information </a>
                            </div> -->
                            <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex">
                                <!-- <button type="button" class="btn btn-primary py-1 px-2">New Group</button> -->
                                <a type="button" href="{{ url('edit_profiles') }}" class="btn btn-outline-secondary py-1 px-2 ml-auto">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                    <!-- END: Profile Menu -->
                        </div>
                    </div>
                </div>

<style>
    strong
    {
        display: inline-block;
        width: 30%;
    }
    .arrow-icon 
    {
        height: 16;
        width: 16;
    }
</style>
@endsection