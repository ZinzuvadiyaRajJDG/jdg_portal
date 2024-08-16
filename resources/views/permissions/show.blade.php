@php
$name = 'permissions';
@endphp
@extends('layouts.app')
@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Permission Details
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: permission Table -->
            <div class="intro-y box p-5">
                <table class="table table-report">
                    <thead>
                        <tr>
                            <th class="whitespace-no-wrap">Role Name</th>
                            <th class="whitespace-no-wrap">Guard Name</th>
                            <th class="text-center whitespace-no-wrap">Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr class="intro-x">
                                <td class="font-medium">{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                {{-- <td class="text-center">
                                    @foreach ($permission as $permission)
                                        <span class="bg-gray-200 px-2 py-1 rounded-lg mr-1">{{ $permission->name }}</span>
                                    @endforeach
                                </td> --}}
                            </tr>
                    </tbody>
                </table>
            </div>
            <!-- END: permission Table -->
        </div>
    </div>
@endsection
