@extends('layouts.app')


@section('content')
    @php

        $name = 'teams';

    @endphp
    <h2 class="intro-y text-lg font-medium mt-10">
        Management Teams
    </h2>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 sm:col-span-6 flex flex-wrap sm:flex-nowrap items-end">
            @can('team-create')
                <a class="btn btn-primary shadow-md mr-2 mb-3" href="{{ route('teams.create') }}">Create New Team</a>
            @endcan
        </div>
        <div
            class="intro-y col-span-12 sm:col-span-6 flex flex-wrap sm:flex-nowrap items-center mt-2 justify-start sm:justify-end">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form method="GET" action="{{ url('teams') }}">
                    <div class="grid grid-cols-12 gap-3 mt-5 items-end">
                       
                        <div class="intro-y col-span-12 sm:col-span-4">
                            <label for="date">Date:</label><br>
                            <select name="date" id="date" class="form-select">
                                <option value="">Select an Option</option>
                                <option value="desc" {{ (isset($_GET['date']) && $_GET['date'] == 'desc')? 'selected' : '' }}>Latest to Old</option>
                                <option value="asc" {{ (isset($_GET['date']) && $_GET['date'] == 'asc')? 'selected' : '' }}>Old to latest</option>
                            </select>
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4">
                            <label for="name">Name:</label><br>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                        </div>
                        <div class="intro-y col-span-12 sm:col-span-4">                                
                            <button type="submit" class="btn btn-primary whitespace-nowrap">Apply Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="intro-y col-span-12 overflow-auto xl:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Name</th>
                        <th class="whitespace-nowrap">Position</th>
                        <th class="whitespace-nowrap">Roles</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($data) > 0)
                        @foreach ($data as $user)
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $role)
                                    @php $role_name =  $role; @endphp
                                @endforeach
                            @endif
                                <tr class="intro-x">
                                    <td>
                                        <a href="{{ route('teams.show', $user->id) }}"
                                            class="font-medium whitespace-nowrap">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td class=" whitespace-nowrap">{{ $user->position }}</td>
                                    <td class=" whitespace-nowrap">
                                        <label class="badge bg-success capitalize">{{ $role_name }}</label>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($user->status == 'Active')
                                            <form action="{{ url('teams/status/' . $user->id) }}" method="post"
                                                style="margin-bottom: 0px;" class="">
                                                @csrf
                                                <button class="flex items-center lg:justify-center text-theme-9"
                                                    type="submit">
                                                    <i data-feather="check" class="w-4 h-4 mr-1"></i> Active

                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ url('teams/status/' . $user->id) }}" method="post"
                                                style="margin-bottom: 0px;" class="">
                                                @csrf
                                                <button class="flex items-center lg:justify-center text-theme-6"
                                                    type="submit">
                                                    <i data-feather="x" class="w-4 h-4 mr-1"></i> Inactive

                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            @can('team-show')
                                                <a class="flex items-center mr-3" href="{{ route('teams.show', $user->id) }}">
                                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                                </a>
                                            @endcan
                                            @can('team-edit')
                                                <a class="flex items-center mr-3" href="{{ route('teams.edit', $user->id) }}">
                                                    <i data-feather="edit" class="w-4 h-4 mr-1"></i>
                                                </a>
                                                <a class="flex items-center text-theme-6" href="javascript:;"
                                                    data-toggle="modal"
                                                    data-target="#delete-confirmation-modal{{ $user->id }}"> <i
                                                        data-feather="trash-2" class="w-4 h-4 mr-1"></i> </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="delete-confirmation-modal{{ $user->id }}" class="modal" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="p-5 text-center">
                                                    <i data-feather="x-circle"
                                                        class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                    <div class="text-gray-600 mt-2">
                                                        Do you really want to delete these records?
                                                        <br>
                                                        This process cannot be undone.
                                                    </div>
                                                </div>
                                                <div class="px-5 pb-8 text-center">
                                                    {{-- @foreach ($users as $user) --}}
                                                    <form action="{{ route('teams.destroy', $user->id) }}" method="POST">
                                                        <button type="button" data-dismiss="modal"
                                                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                    {{-- @endforeach --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Delete Confirmation Modal -->
                        @endforeach 
                    @else
                        <tr>
                            <td class="text-center mt-5" colspan="8"
                                style="background-color: transparent;box-shadow: none;font-weight: 700;font-size: 28px;">
                                Data Not Found..!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
