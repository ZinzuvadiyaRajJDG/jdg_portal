@php
$name = 'attendance';
$currentYear = date('Y');
    $monthName = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
@endphp

@extends('layouts.app')
@section('content')

<h2 class="intro-y text-lg font-medium mt-10">
    Attendance List
</h2>
@can('attendance-admin-list')

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 overflow-auto ">
        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Name</th>
                    <th class="whitespace-nowrap text-center">Date</th>
                    <th class="whitespace-nowrap text-center">Clock In</th>
                    <th class="whitespace-nowrap text-center">Clock Out</th>
                    <th class="whitespace-nowrap text-center">Total Hours</th>
                    <th class="text-center whitespace-nowrap text-center" colspan="3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendancesAdmin as $attendanceAdmin)
                <!-- Use a form for each attendance row -->
                <form id="updateStatusForm" action="{{ url('/attendance/update-status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="attendanceId" value="{{ $attendanceAdmin->id }}">
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">
                            <a href="{{ url('attendance/user',$attendanceAdmin->user->id) }}">
                                {{ $attendanceAdmin->user->name ?? '' }}
                            </a>
                            @if ($attendanceAdmin->late == 1)
                                <a class="btn btn-sm attendance-status-btn btn-rounded-danger p-1">
                                        Late  
                                </a>
                            @endif
                        </td>
                        <td class="text-center whitespace-nowrap">{{ $attendanceAdmin->date }}</td>
                        <td class="text-center whitespace-nowrap">{{ $attendanceAdmin->clock_in }}</td>
                        <td class="text-center whitespace-nowrap">{{ $attendanceAdmin->clock_out }}</td>
                        <td class="text-center whitespace-nowrap">{{ $attendanceAdmin->total_hour }}</td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <!-- Use a submit button to trigger the form submission -->
                                <button type="submit" name="status" value="present" class="btn btn-sm w-15 mr-1 mb-2 {{ $attendanceAdmin->status === 'present' ? 'active btn-success' : 'btn-outline-success' }}">Present</button>
                                <button type="submit" name="status" value="absent" class="btn btn-sm w-15 mr-1 mb-2 {{ $attendanceAdmin->status === 'absent' ? 'active btn-danger' : 'btn-outline-danger' }}">Absent</button>
                                <button type="submit" name="status" value="half day" class="btn btn-sm w-20 mr-1 mb-2 {{ $attendanceAdmin->day === 'half day' ? 'active btn-warning' : 'btn-outline-danger' }}">Half Day</button>
                                <button type="submit" name="status" value="paid holiday" class="btn btn-sm w-24 mr-1 mb-2 {{ $attendanceAdmin->status === 'paid holiday' ? 'active btn-primary' : 'btn-outline-primary' }}">Paid Holiday</button>
                            </div>
                        </td>
                    </tr>
                </form>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endcan     







@can('attendance-user-list')

{{-- User code --}}

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

<div class="grid grid-cols-12 gap-6 mt-5 ">
    <div class="intro-y lg:col-span-6 col-span-12  flex flex-wrap sm:flex-nowrap mt-2 mb-3  " style="align-items: end">
        @if ($clockInDisabled)
            <a id="clock-in-input" name="clock_in" class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;" disabled>Clock In</a>
        @else
            <a id="clock-in-input" name="clock_in" class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;"
                href="{{ url('attendance/create') }}">Clock In</a>
        @endif
        @if ($clockOutDisabled)
                <a id="clock-in-input" name="clock_in" class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;"
                disabled>Clock Out</a>
        @else
            @if($eqlTimeCount == false)
                <a id="clock-in-input" name="clock_in" class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;"
                disabled>Clock Out</a>
            @else
                <a id="clock-out-input" name="clock_out" class="btn btn-primary shadow-md mr-2" style="height: 2.5rem;"
                href="{{ url('attendance/clockout') }}">Clock Out</a>
            @endif
        @endif
       
        <div class="hidden md:block mx-auto text-gray-600"></div>
    </div>
    <div class="intro-y lg:col-span-6 col-span-12 flex flex-wrap sm:flex-nowrap mt-2 justify-end">
        <form method="GET" action="{{ url('attendance') }}" style="width: 100%">
            <label for="" class="form-label">Monthly Attendance</label><br>
            <select name="month" id="year" class="form-control" style="width:32%;" required>
                <option value="">Select Month</option>
                @for ($month = 0; $month <= 11; $month++)
                    <option value="<?= $month + 1 ?>" {{ request('month') == $month + 1 ? 'selected' : '' }}>
                        <?= $monthName[$month] ?></option>
                @endfor
            </select>
            <select name="year" id="year" class="form-control" style="width:32%;" required>
                <option value="">Select year</option>
                @for ($i = 2020; $i <= $currentYear; $i++)
                    <option value="<?= $i ?>" {{ request('year') == $i ? 'selected' : '' }}><?= $i ?></option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary p-auto" style="width: auto; font-size: 12px;">Apply Filter</button>
        </form>
    </div>
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        
        @if (session('error'))
            <div class="error-msg">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="whitespace-nowrap">Name</th>
                    <th class="whitespace-nowrap">Date</th>
                    <th class="whitespace-nowrap text-center">Clock In</th>
                    <th class="whitespace-nowrap text-center">Clock Out</th>
                    <th class="whitespace-nowrap text-center">Total Hour</th>
                    <th class="text-center whitespace-nowrap text-center">Status</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($attendances as $attendance)
                    <tr class="intro-x">
                        <td>
                            @if($attendance->clock_in)
                                <a href="{{ url('attendance/'.$attendance->id) }}"
                                    class="font-medium whitespace-nowrap">{{ $attendance->user->name ?? 'N/A' }} </a>
                                @if ($attendance->late == 1)
                                    <a class="btn btn-sm attendance-status-btn btn-rounded-danger p-1">
                                        Late
                                    </a>
                                @endif

                            @else
                                <div class="font-medium whitespace-nowrap" style="color: gray">{{ $attendance->user->name ?? 'N/A' }} </a>
                            @endif
                        </td>
                        <td>
                            <a href="" class="font-medium whitespace-nowrap">{{ $attendance->date }}</a>
                        </td>
                        <td class="text-center">{{ $attendance->clock_in }}</td>
                        <td class="text-center">{{ $attendance->clock_out }}</td>
                        <td class="text-center">{{ $attendance->total_hour }}</td>
                        <td class="table-report__action w-56 text-center">
                            @php
                                $statusClass = '';
                                
                                switch ($attendance->status) {
                                    case 'present':
                                        $statusClass = 'btn-rounded-success';
                                        break;
                                    case 'absent':
                                        $statusClass = 'btn-rounded-danger';
                                        break;
                                    case 'half day':
                                        $statusClass = 'btn-rounded-warning';
                                        break;
                                    case 'paid holiday':
                                        $statusClass = 'btn-rounded-primary';
                                        break;
                                }
                            @endphp

                            @if ($attendance->status)
                                <a class="btn btn-sm attendance-status-btn {{ $statusClass }}">
                                    {{ $attendance->status }}
                                </a>
                            @endif
                            {{-- @if ($attendance->status == 'paid holiday')
                                        <a class="btn btn-rouned-primary btn-sm attendance-status-btn">
                                            {{ $attendance->status }}
                                        </a>
                                    @endif --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        
    </div>

    @endcan
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
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.updateStatusForm').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Use FormData to serialize the form data
                const formData = new FormData(this);

                // Make an AJAX request to update the status
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'status': formData.get('status'),
                        'attendanceId': formData.get('attendanceId')
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the response data (success or error)
                        if (data.message) {
                            // Display a success message (you can use a library like SweetAlert)
                            alert(data.message);
                        } else if (data.error) {
                            // Display an error message (you can use a library like SweetAlert)
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Add an event listener to each status button (if needed)
        document.querySelectorAll('.status-button').forEach(button => {
            button.addEventListener('click', function () {
                // Find the closest form element and submit it
                const form = this.closest('.updateStatusForm');
                if (form) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

