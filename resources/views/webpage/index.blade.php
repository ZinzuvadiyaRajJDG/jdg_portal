<?php
    $name = "webpage";
?>
@extends('layouts.app')
@section('content')

<div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Manage Webpage
                        </h2>
                        <!-- <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> -->
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('webpage/banner/create') }}">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="text-2xl font-medium leading-8 mt-6">Banner Image</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('webpage/notice/create') }}">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="text-2xl font-medium leading-8 mt-6">Notice Board</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('webpage/iconlink/index') }}">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="text-2xl font-medium leading-8 mt-6">Icon Links</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('webpage/quicklink/index') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="text-2xl font-medium leading-8 mt-6">Quick Links</div>
                                </div>
                            </div>
                            </a>
                        </div>
                       
                    </div>
                </div>
                <!-- END: General Report -->
            </div>
        </div>

    </div>

@endsection