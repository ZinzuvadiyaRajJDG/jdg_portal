@php
    $name = 'leave';
    $currentYear = date('Y');
    $monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
@endphp
@extends('layouts.app')
@section('content')
    <style>
        .leave_reason p {
            margin-bottom: 10px;
        }
        .btn-slate-secondary{
            background-color: #cbd5e133;
        }
        .btn-slate-dark{
            background-color: #1e293b33;
        }
        .btn-slate-warning{
            background-color: #facc1533;
        }
        .btn-slate-danger{
            background-color: #dc262633;
        }
        .btn-slate-primary{
            background-color: #1e3a8a33;
        }
        .btn-slate-success{
            background-color: #84cc1633;
        }
    </style>

    <h2 class="intro-y text-lg font-medium mt-10">
        Leave List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        @can('leave-create')
            <div class="intro-y md:col-span-6 col-span-12 flex flex-wrap sm:flex-nowrap items-end mb-3 mt-2">
                <a class="btn btn-primary shadow-md " href="{{ url('leave/create') }}">Add Leaves</a>
            </div>
        @endcan
        <div class="intro-y col-span-12 sm:col-span-9 lg:col-span-6 flex flex-wrap sm:flex-nowrap mt-2 justify-end">

            <form method="GET" action="{{ url('leave') }}" class="w-full">
                <label for="" class="form-label">Monthly Leave</label><br>
                <select name="month" id="year" class="form-control" style="width:32%;" required>
                    <option value="">Select Month</option>
                    @for ($month = 0; $month <= 11; $month++)
                        <option value="<?= $month + 1 ?>" {{ request('month') == $month + 1 ? 'selected' : '' }}>
                            <?= $monthName[$month] ?>
                        </option>
                    @endfor
                </select>
                <select name="year" id="year" class="form-control" style="width:32%;" required>
                    <option value="">Select year</option>
                    @for ($i = 2020; $i <= $currentYear; $i++)
                        <option value="<?= $i ?>" {{ request('year') == $i ? 'selected' : '' }}><?= $i ?></option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary" style="width: auto; font-size: 12px;">Apply Filter</button>
            </form>
            <div class="hidden md:block mx-auto text-gray-600"></div>


        </div>
        
        @can('leave-admin-list')
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto ">
            <!-- @dump($leavesAdmin) -->
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center whitespace-nowrap">Leave Details</th>
                        <th class="text-center whitespace-nowrap">Start Leave Date</th>
                        <th class="text-center whitespace-nowrap">End Leave Date</th>
                        <th class="text-center">Leave Type</th>
                        <th class="text-center">Day</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($leavesAdmin) > 0)
                    @foreach ($leavesAdmin as $leaveAdmin)
                        @if (!empty($leaveAdmin->user->getRoleNames()))
                            @foreach ($leaveAdmin->user->getRoleNames() as $role)
                                @php $role_name =  $role; @endphp
                            @endforeach
                        @endif
                    {{-- {{ dd($role_name) }} --}}
                    @can('management-team-leave')
                        <tr class="intro-x">
                            <td class="text-center whitespace-nowrap"><a
                                    href="{{ url('leave', $leaveAdmin->user->id) }}">{{ $leaveAdmin->user->name }}</a></td>
                            <td class="text-center whitespace-nowrap">
                                <a class=" text-theme-1" href="javascript:;" data-toggle="modal"
                                    data-target="#detail-modal{{ $leaveAdmin->id }}"> Details <i
                                        data-feather="chevrons-right" class="w-4 h-4 mr-1"></i></a>
                            </td>
                            <td class="text-center whitespace-nowrap">{{ $leaveAdmin->start_leave_date }}</td>
                            <td class="text-center whitespace-nowrap">{{ ($leaveAdmin->end_leave_date)? $leaveAdmin->end_leave_date : $leaveAdmin->start_leave_date}}</td>
                            <td class="text-center whitespace-nowrap">
                                @php 
                                switch ($leaveAdmin->day) {
                                    case 'half day':
                                        $btn_class = "btn-slate-secondary";
                                        break;

                                    case 'full day':
                                        $btn_class = "btn-slate-dark";
                                        break;

                                    case 'medical leave':
                                        $btn_class = "btn-slate-warning text-theme-12";
                                        break;

                                    case 'emergency leave':
                                        $btn_class = "btn-slate-danger  text-theme-6";
                                        break;

                                    case 'paid holiday':
                                        $btn_class = "btn-slate-primary text-theme-1";
                                        break;

                                    case 'casual leave':
                                        $btn_class = "btn-slate-success text-theme-9";
                                        break;
                                }
                                @endphp
                                <span class="capitalize cursor-pointer rounded-full {{ $btn_class }} px-2 py-1 text-xs font-medium ">
                                    @if( $leaveAdmin->day == "paid holiday")
                                        Paid Leave
                                    @else
                                        {{ $leaveAdmin->day }} 
                                    @endif

                                </span>
                            </td>
                            <td class="text-center whitespace-nowrap">{{ $leaveAdmin->total_day }} {{ ($leaveAdmin->total_day >1)? "Days Leave" : "Day Leave" }}</td>
                            {{-- <td class="text-center">
                                        <span class="btn btn-sm  {{ $leaveAdmin->status === 'approved' ? 'btn-rounded-success' : ($leaveAdmin->status === 'rejected' ? 'btn-rounded-danger' : '') }}">
                                            {{ $leaveAdmin->status }}
                                        </span>
                                    </td> --}}
                            <td class="text-center whitespace-nowrap">
                               
                                        @if ($leaveAdmin->status === 'Pending')
                                            <div  name="status" value="Pending" class="btn btn-sm w-15 mr-1 mb-2 active btn-primary">Pending</div>
                                        @else
                                            <a class="btn btn-sm w-15 mr-1 mb-2 btn-outline-primary" href="javascript:;" data-toggle="modal" data-target="#pending-change-status-massage-modaladmin{{ $leaveAdmin->id }}"> Pending </a>
                                        @endif
                                         @if ($leaveAdmin->status === 'approved')
                                            <div  name="status" value="approved" class="btn btn-sm w-15 mr-1 mb-2 active btn-success">Approved</div>
                                        @else
                                            <a class="btn btn-sm w-15 mr-1 mb-2 btn-outline-success" href="javascript:;" data-toggle="modal" data-target="#approve-change-status-massage-modaladmin{{ $leaveAdmin->id }}"> Approve </a>
                                        @endif
                                        @if ($leaveAdmin->status === 'rejected')
                                            <div name="status" value="rejected" class="btn btn-sm w-15 mr-1 mb-2 active btn-danger cursor-not-allowed">Rejected</div>
                                        @else
                                            <a class="btn btn-sm w-15 mr-1 mb-2 btn-outline-danger" href="javascript:;" data-toggle="modal" data-target="#rejection-massage-modaladmin{{ $leaveAdmin->id }}"> Reject </a>
                                        @endif
                            </td>

                        </tr>
                    @else
                        @if ($role_name != Auth::user()->roles->first()->name || $leaveAdmin->user_id == Auth::user()->id)
                        <tr class="intro-x">
                            <td class="text-center whitespace-nowrap"><a
                                    href="{{ url('leave', $leaveAdmin->user->id) }}">{{ $leaveAdmin->user->name }}</a></td>
                            <td class="text-center whitespace-nowrap">
                                <a class=" text-theme-1" href="javascript:;" data-toggle="modal"
                                    data-target="#detail-modal{{ $leaveAdmin->id }}"> Details <i
                                        data-feather="chevrons-right" class="w-4 h-4 mr-1"></i></a>
                            </td>
                            <td class="text-center whitespace-nowrap">{{ $leaveAdmin->start_leave_date }}</td>
                            <td class="text-center whitespace-nowrap">{{ ($leaveAdmin->end_leave_date)? $leaveAdmin->end_leave_date : $leaveAdmin->start_leave_date}}</td>
                            <td class="text-center whitespace-nowrap">
                                @php 
                                switch ($leaveAdmin->day) {
                                    case 'half day':
                                        $btn_class = "btn-slate-secondary";
                                        break;

                                    case 'full day':
                                        $btn_class = "btn-slate-dark";
                                        break;

                                    case 'medical leave':
                                        $btn_class = "btn-slate-warning text-theme-12";
                                        break;

                                    case 'emergency leave':
                                        $btn_class = "btn-slate-danger  text-theme-6";
                                        break;

                                    case 'paid holiday':
                                        $btn_class = "btn-slate-primary text-theme-1";
                                        break;

                                    case 'casual leave':
                                        $btn_class = "btn-slate-success text-theme-9";
                                        break;
                                }
                                @endphp
                                <span class="capitalize cursor-pointer rounded-full {{ $btn_class }} px-2 py-1 text-xs font-medium ">
                                    @if( $leaveAdmin->day == "paid holiday")
                                        Paid Leave
                                    @else
                                        {{ $leaveAdmin->day }} 
                                    @endif

                                </span>
                            </td>
                            <td class="text-center whitespace-nowrap">{{ $leaveAdmin->total_day }} {{ ($leaveAdmin->total_day >1)? "Days Leave" : "Day Leave" }}</td>
                            {{-- <td class="text-center">
                                        <span class="btn btn-sm  {{ $leaveAdmin->status === 'approved' ? 'btn-rounded-success' : ($leaveAdmin->status === 'rejected' ? 'btn-rounded-danger' : '') }}">
                                            {{ $leaveAdmin->status }}
                                        </span>
                                    </td> --}}
                            <td class="text-center whitespace-nowrap">
                                @if($role_name ==  Auth::user()->roles->first()->name)
                                    -
                                @else
                                        @if ($leaveAdmin->status === 'Pending')
                                            <div  name="status" value="Pending" class="btn btn-sm w-15 mr-1 mb-2 active btn-primary">Pending</div>
                                        @else
                                            <a class="btn btn-sm w-15 mr-1 mb-2 btn-outline-primary" href="javascript:;" data-toggle="modal" data-target="#pending-change-status-massage-modaladmin{{ $leaveAdmin->id }}"> Pending </a>
                                        @endif
                                         @if ($leaveAdmin->status === 'approved')
                                            <div  name="status" value="approved" class="btn btn-sm w-15 mr-1 mb-2 active btn-success">Approved</div>
                                        @else
                                            <a class="btn btn-sm w-15 mr-1 mb-2 btn-outline-success" href="javascript:;" data-toggle="modal" data-target="#approve-change-status-massage-modaladmin{{ $leaveAdmin->id }}"> Approve </a>
                                        @endif
                                        @if ($leaveAdmin->status === 'rejected')
                                            <div name="status" value="rejected" class="btn btn-sm w-15 mr-1 mb-2 active btn-danger cursor-not-allowed">Rejected</div>
                                        @else
                                            <a class="btn btn-sm w-15 mr-1 mb-2 btn-outline-danger" href="javascript:;" data-toggle="modal" data-target="#rejection-massage-modaladmin{{ $leaveAdmin->id }}"> Reject </a>
                                        @endif
                                @endif
                            </td>

                        </tr>
                        @endif
                    @endcan

                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="detail-modal{{ $leaveAdmin->id }}" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 ">
                                            {{-- <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> --}}
                                            <div class="text-3xl mt-5">{{ $leaveAdmin->leave_heading }}</div>
                                            <div class="text-gray-600 mt-2 leave_reason">
                                                {!! $leaveAdmin->leave_reason !!}
                                            </div>
                                            <div class="text-lg mt-5">Total Day :- {{ $leaveAdmin->total_day }}</div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            {{-- @foreach ($employees as $employee) --}}
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Delete Confirmation Modal -->

                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="rejection-massage-modaladmin{{ $leaveAdmin->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <form action="{{ url('leave/update-status') }}" method="POST">
                                            @csrf

                                            <div class="p-5 text-center">
                                                <div class="text-3xl mt-5">Rejection Message</div>
                                                <div class="text-gray-600 mt-4">
                                                    <input type="hidden" name="leaveId" value="{{ $leaveAdmin->id }}">
                                                    <textarea name="rejection_massage" id="" rows="10" class="form-control"
                                                        placeholder="Write a Rejection Massage" required>Dear {{ $leaveAdmin->user->name }},

I hope this message finds you well.

I regret to inform you that your leave request for {{ $leaveAdmin->start_leave_date }}{{ ($leaveAdmin->end_leave_date)? " to ".$leaveAdmin->end_leave_date : ""}} cannot be approved at this time. 

Please note that we appreciate your dedication and understand the importance of taking time off. However, [Reason of leave rejection].


Thank you for your understanding.

Best regards,
HR Manager
Just Digital Gurus </textarea>
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center">
                                                {{-- @foreach ($employees as $employee) --}}
                                                <button type="button" data-dismiss="modal"
                                                    class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                <button type="submit" name="status" value="rejected"
                                                    class="btn btn-danger w-24">Rejected</button>
                                                {{-- @endforeach --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="approve-change-status-massage-modaladmin{{ $leaveAdmin->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 text-center">
                                            <i data-feather="x-circle"
                                                class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                            <div class="text-3xl mt-5">Are you sure?</div>
                                            <div class="text-gray-600 mt-2">
                                                Do you really want to Change Status of these records?
                                                <br>
                                                This process cannot be undone.
                                            </div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            
                                            <form action="{{ url('leave/update-status') }}" method="POST">
                                                    <button type="button" data-dismiss="modal"
                                                        class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                    @csrf
                                                    <input type="hidden" name="leaveId" value="{{ $leaveAdmin->id }}">
                                                    <button type="submit"  name="status" value="approved" class="btn btn-danger">Submit</button>
                                            </form>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pending-change-status-massage-modaladmin{{ $leaveAdmin->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 text-center">
                                            <i data-feather="x-circle"
                                                class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                                            <div class="text-3xl mt-5">Are you sure?</div>
                                            <div class="text-gray-600 mt-2">
                                                Do you really want to Change Status of these records?
                                                <br>
                                                This process cannot be undone.
                                            </div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            
                                            <form action="{{ url('leave/update-status') }}" method="POST">
                                                    <button type="button" data-dismiss="modal"
                                                        class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                                    @csrf
                                                    <input type="hidden" name="leaveId" value="{{ $leaveAdmin->id }}">
                                                    <button type="submit"  name="status" value="Pending" class="btn btn-danger">Submit</button>
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
                            <td class="text-center mt-5" colspan="8" style="background-color: transparent;box-shadow: none;font-weight: 700;font-size: 28px;">Data Not Found..!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        @endcan


        @can('leave-user-list')
        
        <div class="intro-y md:col-span-6 col-span-12 flex flex-wrap sm:flex-nowrap items-end mb-3 mt-2">
            <h4 class="intro-y text-md font-medium mt-5">
                Total Left Paid Leaves :-
                <span style="color: green">
                    @php 
                        $pending_paid_leaves = 12 - $paid_leaves;
                    @endphp
                    {{ $pending_paid_leaves }}
                </span>
            </h4>
        </div>

        <div class="intro-y col-span-12 overflow-auto ">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap text-center">User Name</th>
                        <th class="whitespace-nowrap text-center">Leave Details</th>
                        <th class="whitespace-nowrap text-center">Start Leave Date</th>
                        <th class="whitespace-nowrap text-center"> End Leave Date</th>
                        <th class="whitespace-nowrap text-center"> Day</th>
                        <th class="whitespace-nowrap text-center"> No. of Day</th>
                        <th class="whitespace-nowrap text-center"> Status</th>
                        <th class="whitespace-nowrap text-center"> Action</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($leaves) > 0)
                    @foreach ($leaves as $leave)
                        <tr class="intro-x">
                            <td class="text-center">{{ $leave->user->name }}</td>
                            <td class="text-center">
                                <a class=" text-theme-1" href="javascript:;" data-toggle="modal"
                                    data-target="#detail-modaluser{{ $leave->id }}"> Details <i
                                        data-feather="chevrons-right" class="w-4 h-4 mr-1"></i></a>
                            </td>
                            <td class="text-center">{{ $leave->start_leave_date }}</td>
                            <td class="text-center">{{ ($leave->end_leave_date)? $leave->end_leave_date : $leave->start_leave_date}}</td>
                            <td class="text-center">{{ $leave->day }}</td>
                            <td class="text-center">{{ $leave->total_day }}</td>
                            <td class="text-center">
                                @php
                                    $statusClass = '';

                                    switch ($leave->status) {
                                        case 'Pending':
                                            $statusClass = 'btn-rounded-primary';
                                            break;
                                        case 'approved':
                                            $statusClass = 'btn-rounded-success';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'btn-rounded-danger';
                                            break;
                                    }
                                @endphp

                                @if ($leave->status)
                                    @if ($leave->status === 'rejected')
                                        <a class="btn btn-sm attendance-status-btn btn-rounded-danger" href="javascript:;"
                                            data-toggle="modal"
                                            data-target="#rejection-massage-modal{{ $leave->id }}">rejected</a>
                                    @else
                                        <a class="btn btn-sm attendance-status-btn {{ $statusClass }}">
                                            {{ $leave->status }}
                                        </a>
                                    @endif()
                                @endif
                            </td>

                            <td class="table-report__action">
                                @can('leave-edit')
                                    @if ($leave->status == 'approved' || $leave->status == 'rejected')
                                        <div class="flex items-center mr-3 gap-3" style="color: gray">
                                            <div class="flex items-center"><i data-feather="check-square" class="w-4 h-4 mr-1"></i></div>
                                            <div class="flex items-center"><i data-feather="trash-2" class="w-4 h-4 mr-1"></i></div>
                                        </div>
                                        @else
                                        <div class="flex items-center gap-3">
                                            <a class="flex items-center"
                                                href="{{ url('leave/' . $leave->id . '/edit') }}"><i data-feather="check-square"
                                                    class="w-4 h-4 mr-1"></i></a>
                                            <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal"
                                                data-target="#delete-confirmation-modal{{ $leave->id }}"> <i
                                                    data-feather="trash-2" class="w-4 h-4 mr-1"></i></a>
                                        </div>
                                    @endif
                                @endcan
                                
                            </td>
                        </tr>
                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="delete-confirmation-modal{{ $leave->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
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
                                            {{-- @foreach ($users as $user) --}}
                                            <form action="{{ route('leave.destroy', $leave->id) }}" method="POST">
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
                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="detail-modaluser{{ $leave->id }}" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 ">
                                            {{-- <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> --}}
                                            <div class="text-3xl mt-5">{{ $leave->leave_heading }}</div>
                                            <div class="text-gray-600 mt-3">
                                                {!! $leave->leave_reason !!}
                                            </div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            {{-- @foreach ($employees as $employee) --}}
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                                            {{-- @endforeach --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Delete Confirmation Modal -->
                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="rejection-massage-modal{{ $leave->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5">
                                            {{-- <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i> --}}
                                            <div class="text-3xl mt-5">{{ $leave->leave_heading }}</div>
                                            <div class="text-gray-600 mt-3">
                                                {{ $leave->rejection_massage }}
                                            </div>
                                        </div>
                                        <div class="px-5 pb-8 text-center">
                                            {{-- @foreach ($employees as $employee) --}}
                                            <button type="button" data-dismiss="modal"
                                                class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
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
                            <td class="text-center mt-5" colspan="8" style="background-color: transparent;box-shadow: none;font-weight: 700;font-size: 28px;">Data Not Found..!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @endcan
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
    
    @if(session('error'))
        swal({
            title: "{{ session('error') }}",
            icon: "error",
            button: "OK",
        })
    @endif
    
    </script>
    <script>
        // Wait for the DOM to be ready
        $(document).ready(function() {
            // Handle button click event
            $(".leave-status-btn").on("click", function() {
                // Get the salary ID and current status from the data attributes
                const leaveId = $(this).data("leave-id");
                const currentStatus = $(this).data("leave-status");

                // Determine the new status
                const newStatus = currentStatus === "Approved" ? "Pending" : "Approved";

                // Send an AJAX request to update the salary status
                $.ajax({
                    url: "/admin/update-leave-status", // Replace with the URL to your Laravel route/controller method
                    method: "POST",
                    data: {
                        leave_id: leaveId,
                        status: newStatus,
                    },
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // Add CSRF token to the request
                    },
                    success: function(response) {
                        // On success, update the button text and class
                        $(`button[data-leave-id='${leaveId}']`)
                            .text(newStatus)
                            .removeClass(currentStatus === "Approved" ? "btn-rounded-success" :
                                "btn-rounded-warning")
                            .addClass(newStatus === "Approved" ? "btn-rounded-success" :
                                "btn-rounded-warning")
                            .data("leave-status", newStatus);
                    },
                    error: function(xhr) {
                        // Handle errors if necessary
                        console.error("Error:", xhr.responseText);
                    },
                });
            });
        });
    </script>
@endsection
