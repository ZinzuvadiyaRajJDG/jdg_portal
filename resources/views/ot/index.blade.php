@php
    $name = 'overtime';
    $currentYear = date('Y');
    $monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
@endphp
@extends('layouts.app')
@section('content')
    <style>
        .custom-success-message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 10px;
            margin-bottom: 20px;
        }

        .info-msg,
        .success-msg,
        .warning-msg,
        .error-msg {
            margin: 10px 0;
            padding: 10px;
            border-radius: 3px 3px 3px 3px;
        }

        .error-msg {
            color: #D8000C;
            background-color: #FFBABA;
        }

        .success-msg {
            color: #270;
            background-color: #DFF2BF;
        }
    </style>
    <h2 class="intro-y text-lg font-medium mt-10">
        overtime List
    </h2>
    {{-- <p class="mt-5">overtime will be consider after 7:30 PM to 12:00 AM</p> --}}

    <div class="grid grid-cols-12 gap-6 mt-5">
        @canany(['overtime-clockin', 'overtime-clockout'])
            <div class="intro-y lg:col-span-6 col-span-12 flex flex-wrap sm:flex-nowrap mt-2 mb-2 items-end">
                @php

                    $currentDateTimeInIndia = \Carbon\Carbon::now('Asia/Kolkata');
                    // $currentDateTimeInIndia = \Carbon\Carbon::createFromTime(23, 0, 0, 'Asia/Kolkata'); // for check the code
                    $startTime = \Carbon\Carbon::createFromTime(6, 0, 0, 'Asia/Kolkata');
                    $endTime = \Carbon\Carbon::createFromTime(19, 30, 0, 'Asia/Kolkata');

                    $disableButton = $currentDateTimeInIndia->between($startTime, $endTime);
                @endphp
                @can('overtime-clockin')
                    @if ($disableButton)
                        {{-- <button id="clock-in-input" class="btn btn-primary shadow-md mr-2" disabled>Clock In</button> --}}
                        <a class="btn btn-primary shadow-md mr-2" href="javascript:;" data-toggle="modal"
                            data-target="#check-in-error-model" style="height: 2.5rem;">Clock In</a>
                    @else
                        <a id="clock-in-input" name="clock_in" class="btn btn-primary shadow-md mr-2"
                            href="{{ url('overtime/create') }}" style="height: 2.5rem;">Clock In</a>
                    @endif
                @endcan

                @can('overtime-clockout')
                    @if ($disableButton)
                        <button id="clock-out-input" name="clock_out" style="height: 2.5rem;" class="btn btn-primary shadow-md mr-2"
                            disabled>Clock
                            Out</button>
                    @else
                        <a id="clock-out-input" name="clock_out" style="height: 2.5rem;" class="btn btn-primary shadow-md mr-2"
                            href="{{ url('overtime/clockout') }}">Clock Out</a>
                    @endif
                @endcan
                <div class="hidden md:block mx-auto text-gray-600"></div>
            </div>
        @endcan

        <div class="intro-y lg:col-span-6 col-span-12 flex flex-wrap sm:flex-nowrap mt-2 justify-end">
            <form method="GET" action="{{ url('overtime') }}" class="w-full">
                <label for="" class="form-label">Monthly Overtime</label><br>
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
                <button type="submit" class="btn btn-primary" style="width:auto; font-size: 12px;">Apply Filter</button>
            </form>
        </div>
    </div>
    @can('overtime-user-list')
        <div class="">
            <h4 class="intro-y text-md font-medium mt-5">
                Total Overtime Salary :-
                <span style="color: green">
                    {{ $totalOvertimeSalary }}
                </span>
            </h4>
        </div>

        <div class="">
            <h4 class="intro-y text-md font-medium mt-2">
                Total Overtime Hours :-
                <span style="color: green">

                    <?php
                    
                    $totalMinutes = 0; // Initialize the total minutes to 0
                    foreach ($overtimes as $overtime) {
                        if ($overtime->total_hour != null) {
                            $totalHour = $overtime->total_hour;
                            // Split the hour:minute string into hours and minutes
                            [$hours, $minutes] = explode(':', $totalHour);
                    
                            // Convert hours to minutes and add to the total
                            $totalMinutes += $hours * 60 + $minutes;
                            // Calculate total hours and remaining minutes
                            $totalHours = floor($totalMinutes / 60);
                            $remainingMinutes = $totalMinutes % 60;
                        
                            // Display the total in the desired format
                            echo $totalHours . ':' . str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT);
                        }
                    
                    }
                    ?>
                </span>
            </h4>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <!--@if (session('success'))
        -->
            <!--    <div class="success-msg">-->
            <!--        {{ session('success') }}-->
            <!--    </div>-->
            <!--
        @endif-->
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Name</th>
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap text-center">Clock In</th>
                        <th class="whitespace-nowrap text-center">Clock Out</th>
                        <th class="whitespace-nowrap text-center">Total Hour</th>
                        <th class="whitespace-nowrap text-center">Overtime Salary</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($overtimes) > 0)
                    @foreach ($overtimes as $overtime)
                        <tr class="intro-x">
                            <td>
                                {{ $overtime->user->name ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $overtime->date }}
                            </td>
                            <td class="text-center">{{ $overtime->clock_in }}</td>
                            <td class="text-center">{{ $overtime->clock_out }}</td>
                            <td class="text-center">{{ $overtime->total_hour }}</td>
                            <td class="text-center">{{ $overtime->overtime_salary }}</td>
                        </tr>
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

    @can('overtime-admin-list')
        <div class="grid grid-cols-12 gap-6 mt-2">
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto">

                <table class="table table-report -mt-2">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">Name</th>
                            <th class="whitespace-nowrap">Date</th>
                            <th class="whitespace-nowrap text-center">Clock In</th>
                            <th class="whitespace-nowrap text-center">Clock Out</th>
                            <th class="whitespace-nowrap text-center">Total Hour</th>
                            <th class="whitespace-nowrap text-center">Overtime Salary</th>
                            <th class="whitespace-nowrap text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // if(empty($overtimes))
                        // {
                        ?>
                        @if(count($overtimesAdmin) > 0)
                            @foreach ($overtimesAdmin as $overtimeAdmin)
                                <tr class="intro-x">
                                    <td>
                                        <a href="{{ route('overtime.show', $overtimeAdmin->user->id) }}"
                                            class="font-medium whitespace-nowrap">{{ $overtimeAdmin->user->name ?? 'N/A' }}</a>
                                    </td>
                                    <td>
                                        <a href="" class="font-medium whitespace-nowrap">{{ $overtimeAdmin->date }}</a>
                                    </td>
                                    <td class="whitespace-nowrap text-center">{{ $overtimeAdmin->clock_in }}</td>
                                    <td class="whitespace-nowrap text-center">{{ $overtimeAdmin->clock_out }}</td>
                                    <td class="whitespace-nowrap text-center">{{ $overtimeAdmin->total_hour }}</td>
                                    <td class="whitespace-nowrap text-center">{{ $overtimeAdmin->overtime_salary }}</td>
                                    <td class="whitespace-nowrap">
                                        <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal"
                                            data-target="#delete-confirmation-modal{{ $overtimeAdmin->id }}">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                <!-- BEGIN: Delete Confirmation Modal -->
                                <div id="delete-confirmation-modal{{ $overtimeAdmin->id }}" class="modal" tabindex="-1"
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
                                                    {{-- @foreach ($employees as $employee) --}}
                                                    <form action="{{ route('overtime.destroy', $overtimeAdmin->id) }}" method="POST">
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
                                <td class="text-center mt-5" colspan="8" style="background-color: transparent;box-shadow: none;font-weight: 700;font-size: 28px;">Data Not Found..!</td>
                            </tr>
                        @endif
                        <?php
                        // }
                        // else
                        // {
                        ?>
                        {{-- <tr>
                        <td colspan="7" style="background: transparent!important">
                            <div class="flex justify-center font-medium text-lg">
                                Data Not Found
                            </div>
                        </td>
                    </tr> --}}

                        <?php
                        // }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>
    @endcan

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="check-in-error-model" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Error</div>
                        <div class="text-gray-600 mt-2">
                            Overtime will be monitored between
                            <br>
                            7:30 PM to 12:00 AM.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection
@section('js')
    <script>
        // Function to get the current time in 12-hour format with AM/PM
        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';

            // Convert hours to 12-hour format
            const twelveHourFormat = (hours % 12) || 12;
            const formattedHours = String(twelveHourFormat).padStart(2, '0');
            const formattedMinutes = String(minutes).padStart(2, '0');

            const time = formattedHours + ':' + formattedMinutes + ' ' + ampm;
            return time;
        }

        // Assuming you have a way to fetch the attendance data for the current user
        // (Replace this with your actual code to fetch the attendance data)
        function getAttendanceDataForCurrentUser() {
            // Replace this with your implementation to fetch the attendance data
            // for the current user from the server/database.
            // The data should contain the clock_in and clock_out information.
            // For example:
            // return {
            //     clock_in: '09:30 AM',
            //     clock_out: '05:00 PM',
            // };
        }

        const currentUserAttendance = getAttendanceDataForCurrentUser();
        const clockInInput = document.getElementById('clock-in-input');
        const clockOutInput = document.getElementById('clock-out-input');

        if (currentUserAttendance && currentUserAttendance.clock_in) {
            // If the user has already clocked in, disable the "Clock In" button
            clockInInput.value = currentUserAttendance.clock_in;
            clockInInput.disabled = true;

            // If the user has already clocked in, enable the "Clock Out" button
            clockOutInput.value = getCurrentTime();
            clockOutInput.disabled = false;
        } else {
            // If the user has not clocked in, enable the "Clock In" button
            clockInInput.value = getCurrentTime();
            clockInInput.disabled = false;

            // If the user has not clocked in, disable the "Clock Out" button
            clockOutInput.value = getCurrentTime();
            clockOutInput.disabled = true;
        }
    </script>
    <script>
        @if (session('success'))
            swal({
                title: "{{ session('success') }}",
                icon: "success",
                button: "OK",
            })
        @endif
        @if (session('error'))
            swal({
                title: "{{ session('error') }}",
                icon: "error",
                button: "OK",
            })
        @endif
    </script>
@endsection
