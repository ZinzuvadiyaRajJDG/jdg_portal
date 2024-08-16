@php
$name = 'permissions';
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">
                    Manage Permissions
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap mt-2">
                    <a class="btn btn-primary shadow-md mr-2" href="{{ url('permissions/create') }}">Add Permissions</a>
                        {{-- <div class="dropdown">
                            <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                            </button>
                            <div class="dropdown-menu w-40">
                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="hidden md:block mx-auto text-gray-600"></div>
                        {{-- <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                                <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                            </div>
                        </div> --}}
                    </div>
                    <!-- BEGIN: Data List -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">id</th>
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="text-center whitespace-nowrap" colspan="3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                <tr class="intro-x">
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">{{ $permission->id }}</a>
                                    </td>
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">{{ $permission->name }}</a>
                                    </td>
                                    <td class="table-report__action w-56">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="{{ route('permissions.show',$permission->id) }}"><i data-feather="eye" class="w-4 h-4 mr-1"></i>Show</a>
                                            <a class="flex items-center mr-3" href="{{ route('permissions.edit',$permission->id) }}"><i data-feather="check-square" class="w-4 h-4 mr-1"></i>Edit</a>
                                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal{{ $permission->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="delete-confirmation-modal{{ $permission->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="p-5 text-center">
                                                    <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                                    <div class="text-3xl mt-5">Are you sure?</div>
                                                    <div class="text-gray-600 mt-2">
                                                        Do you really want to delete these records?
                                                        <br>
                                                        This process cannot be undone.
                                                    </div>
                                                </div>
                                                <div class="px-5 pb-8 text-center">
                                                    <form action="{{ route('permissions.destroy',$permission->id) }}" method="POST">
                                                            <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                                @csrf
                                                                @method('DELETE')

                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Delete Confirmation Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END: Data List -->
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
@endsection
