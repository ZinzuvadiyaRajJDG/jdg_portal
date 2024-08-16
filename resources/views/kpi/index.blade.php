@php
$name = 'kpi';

$currentDate = date("d-m-Y");
$currentYear = date('Y');
$monthName = ['January','February','March','April','May','June','July','August','September','October','November','December'];
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">
                    KPI Points
                </h2>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    
                    <div class="intro-y col-span-12 md:col-span-6 flex flex-wrap sm:flex-nowrap mt-2 justify-end">
                        <form method="GET" action="{{ url('kpipoints') }}" class="mt-6 w-full">
                            <label for="" class="form-label">Monthly Points </label><br>
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
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="whitespace-nowrap text-center">Regularity</th>
                                    <th class="whitespace-nowrap text-center">Extra</th>
                                    <th class="whitespace-nowrap text-center">Total</th>
                                    @can('kpi-edit')
                                    <th class="text-center whitespace-nowrap text-center">Actions</th>    
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($kpipoints) > 0)
                                    @foreach($kpipoints as $kpipoint)
                                        <tr class="intro-x">
                                            <td class="whitespace-nowrap">{{ $kpipoint->user->name }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $kpipoint->regularity  }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $kpipoint->ctm_points  }}</td>
                                            <td class="text-center whitespace-nowrap">{{ $kpipoint->regularity + $kpipoint->ctm_points  }}</td>
                                            @can('kpi-edit')
                                            <td class="table-report__action w-56 whitespace-nowrap">
                                                <div class="flex justify-center items-center">   
                                                <a class="flex items-center text-theme-3" href="javascript:;"
                                                        data-toggle="modal"
                                                        data-target="#edit-confirmation-modal{{ $kpipoint->id }}"> 
                                                        <i data-feather="edit" class="w-4 h-4 mr-1"></i>
                                                </a>                                          
                                                </div>
                                            </td>
                                            @endcan
                                        </tr>
                                        <!-- BEGIN: EDIT Confirmation Modal -->
                                        <div id="edit-confirmation-modal{{ $kpipoint->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body p-0">
                                                    <form action="{{ route('kpipoints.update',$kpipoint->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="p-5 text-center">
                                                            <div class="text-3xl mt-5">{{ $kpipoint->user->name }} KPI Points</div>
                                                            <input type="number" name="ctm_points" id="ctm_points" class="form-control mt-3" placeholder="Enter Points" value="{{ $kpipoint->ctm_points  }}" required>
                                                        </div>
                                                        <div class="px-5 pb-8 text-center">
                                                                <button type="button" data-dismiss="modal"
                                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
