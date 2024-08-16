@php
$name = 'webpage';
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">
                    QuickList List
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 md:col-span-6 flex flex-wrap sm:flex-nowrap mt-2 items-end mb-3">
                        <a class="btn btn-primary shadow-md mr-2" href="{{ url('webpage/quicklink/create') }}">Add Quick</a>
                        <div class="hidden md:block mx-auto text-gray-600"></div>
                    </div>
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto ">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="whitespace-nowrap text-center">Link</th>
                                    <th class="text-center whitespace-nowrap text-center">Actions</th>    
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($quicklinks) > 0)
                                    @foreach($quicklinks as $quicklink)
                                        <tr class="intro-x">
                                            <td class="whitespace-nowrap">{{$quicklink->name}}</td>
                                            <td class="text-center whitespace-nowrap">{{$quicklink->link}}</td>
                                            <td class="table-report__action w-56 whitespace-nowrap">
                                                <div class="flex justify-center items-center">
                                                    <a class="flex items-center mr-3" href="{{ route('webpage.quicklink.edit',$quicklink->id) }}"><i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit</a>                                            
                                                    <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal{{ $quicklink->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        <div id="delete-confirmation-modal{{ $quicklink->id }}" class="modal" tabindex="-1" aria-hidden="true">
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
                                                            <form action="{{ route('webpage.quicklink.destroy',$quicklink->id) }}" method="POST">
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
                                @else
                                    <tr>
                                        <td class="text-center mt-5" colspan="8" style="background-color: transparent;box-shadow: none;font-weight: 700;font-size: 28px;">Data Not Found..!</td>
                                    </tr>
                                @endif
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
