@php
$name = 'permissions';
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
                        Add Permissions
                    </h2>
                </div>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Something went wrong.<br><br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{route('permissions.store')}}">
                    @csrf
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                            <div>
                                <label for="crud-form-1" class="form-label">Permissions Name</label>
                                <input id="crud-form-1" type="text" name="name" class="form-control w-full" placeholder="permissions">
                                @error('name')
                                    <span class="error_msg">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="text-right mt-5">
                                <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                <button type="submit" class="btn btn-primary w-24">Save</button>
                            </div>
                        </div>
                        <!-- END: Form Layout -->
                    </div>
                </div>
                </form>
@endsection
