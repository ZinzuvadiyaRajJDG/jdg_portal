@php
$name = 'holiday';

$currentDate = date("d-m-Y");
$currentYear = date('Y');
$monthName = ['January','February','March','April','May','June','July','August','September','October','November','December'];
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">
                    Holiday List
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 md:col-span-6 flex flex-wrap sm:flex-nowrap mt-2 items-end mb-3">
                        @can('holiday-create')<a class="btn btn-primary shadow-md mr-2" href="{{ url('holiday/create') }}">Add Holiday</a>@endcan
                        <div class="hidden md:block mx-auto text-gray-600"></div>
                    </div>
                    <div class="intro-y col-span-12 md:col-span-6 flex flex-wrap sm:flex-nowrap mt-2 justify-end">
                        <form method="GET" action="{{ url('holiday') }}" class="mt-6 w-full">
                            <label for="" class="form-label">Monthly Holidays </label><br>
                            <select name="month" id="year" class="form-control" style="width:32%;" required>
                                <option value="">Select Month</option>
                                @for ($month = 0; $month <= 11; $month++)
                                    <option value="<?= $month+1 ?>" {{ request('month') == $month+1 ? 'selected' : '' }}><?= $monthName[$month] ?></option>
                                @endfor
                            </select>
                            <select name="year" id="year" class="form-control" style="width:32%;" required>
                                <option value="">Select year</option>
                                @for ($i = 2020; $i <= $currentYear; $i++)
                                    <option value="<?= $i ?>" {{ request('year') == $i ? 'selected' : '' }}><?= $i ?></option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-primary" style="width: auto; font-size:12px">Apply Filter</button>
                        </form>
                    </div>
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto ">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap text-center">Name</th>
                                    <th class="whitespace-nowrap text-center">Holiday Date</th>
                                    <th class="whitespace-nowrap text-center">Holiday End Date</th>
                                    <th class="whitespace-nowrap text-center">Day</th>
                                    @canany(['holiday-edit', 'holiday-delete'])
                                    <th class="text-center whitespace-nowrap text-center">Actions</th>    
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($holidays) > 0)
                                    @foreach($holidays as $holiday)
                                        <tr class="intro-x">
                                            <td class="text-center whitespace-nowrap">{{$holiday->name}}</td>
                                            <td class="text-center whitespace-nowrap">{{$holiday->date}}</td>
                                            <td class="text-center whitespace-nowrap">{{ ($holiday->end_date)? $holiday->end_date : $holiday->date  }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $holiday->day  }}</td>
                                            @canany(['holiday-edit', 'holiday-delete'])
                                            <td class="table-report__action w-56 whitespace-nowrap">
                                                <div class="flex justify-center items-center">
                                                    @can('holiday-edit')
                                                        @if(strtotime($holiday->date) >= strtotime($currentDate))
                                                            <a class="flex items-center mr-3" href="{{ route('holiday.edit',$holiday->id) }}"><i data-feather="edit" class="w-4 h-4 mr-1"></i> Edit</a>                                            
                                                        @else
                                                            <a class="flex items-center mr-3"><span class="text-gray-500"><i data-feather="edit" class="w-4 h-4 mr-1"></i></span> Edit </a>
                                                        @endif
                                                    @endcan
                                                    @can('holiday-delete')
                                                        <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal{{ $holiday->id }}"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete</a>
                                                    @endcan
                                                    </div>
                                            </td>
                                            @endcanany
                                        </tr>
                                        
                                        <!-- BEGIN: Delete Confirmation Modal -->
                                        <div id="delete-confirmation-modal{{ $holiday->id }}" class="modal" tabindex="-1" aria-hidden="true">
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
                                                            <form action="{{ route('holiday.destroy',$holiday->id) }}" method="POST">
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
