@php
    $name = 'attendance';
    $currentYear = date('Y');
    $monthName = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];

    if ($salary) {
        $month = $salary->month;
        $year = $salary->year;
        $total_salary = isset($salary) ? $salary->salary : '0';

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Calculate the salary per day
        $monthday_salary = $daysInMonth > 0 ? $total_salary / $daysInMonth : 0;
        $salary_30day = $total_salary / 30;
    }

    $late_count = 0;
    foreach ($attendances as $attendance) {
        if ($attendance->late == 1) {
            $late_count += 1;
        }
    }
@endphp

@extends('layouts.app')
@section('content')
<style>
    .btn-rounded-orange {
        background-color: #FF4f00;
        border-radius: 0.375rem;
        color: #fff;
    }
</style>
    <h2 class="intro-y text-lg font-medium mt-10 mb-10">
        Attendance List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-6 xl:col-span-6 intro-y">
            <form method="GET" action="{{ url('attendance/user/' . $user_id) }}" class="">
                <label for="" class="form-label">Monthly Attendance</label><br>
                <select name="month" id="month" class="form-control" style="width:150px;" required>
                    <option value="">Select Month</option>
                    @for ($month = 0; $month <= 11; $month++)
                        <option value="<?= $month + 1 ?>" {{ request('month') == $month + 1 ? 'selected' : '' }}>
                            <?= $monthName[$month] ?></option>
                    @endfor
                </select>
                <select name="year" id="year" class="form-control" style="width:150px;" required>
                    <option value="">Select year</option>
                    @for ($i = 2020; $i <= $currentYear; $i++)
                        <option value="<?= $i ?>" {{ request('year') == $i ? 'selected' : '' }}><?= $i ?></option>
                    @endfor
                </select>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
            </form>
        </div>
        <div class="col-span-12 lg:col-span-6 xl:col-span-6 intro-y text-left lg:text-right">
            <!-- <form method="GET" action="{{ url('attendance/user/' . $user_id) }}" class=""> -->
            <label for="user_id" class="form-label">Search User</label><br>
            <select name="user" id="user_id" class="form-control" style="width:150px;" required>
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary user-change-btn">Apply Filter</button>
            <!-- </form> -->
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-feather="user-check" class="report-box__icon text-theme-10"></i>
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $presentCount }}</div>
                    <div class="text-base text-gray-600 mt-1">Total Day Present</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-feather="user-minus" class="report-box__icon text-theme-11"></i>
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $absentCount }}</div>
                    <div class="text-base text-gray-600 mt-1">Total Day Absent</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-feather="user-plus" class="report-box__icon text-theme-12"></i>
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $halfdayCount }}</div>
                    <div class="text-base text-gray-600 mt-1">Total HalfDay</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <i data-feather="clock" class="report-box__icon text-theme-6"></i>
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="text-3xl font-medium leading-8 mt-6">{{ $late_count }}</div>
                    <div class="text-base text-gray-600 mt-1">Late Comming</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-12 mt-5">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-12 xxl:col-span-6 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5 lg:mt-0 p-5">
                <div class="">
                    Monthly Salary
                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                        {{ isset($salary) ? $salary->salary : '0' }}
                    </span>
                </div>
                <?php if(isset($salary)) { ?>
                <div class="mt-3">
                    Total Salary
                    @php
                        $currnt_total_day = $presentCount + $absentCount + $halfdayCount;
                        $cut_salary = $absentCount * $salary_30day;
                        $cut_half_salary = ($halfdayCount * $salary_30day) / 2;
                        $currnt_day_salary = $currnt_total_day * $monthday_salary - $cut_salary - $cut_half_salary;

                    @endphp

                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                        {{-- @php $total_salary = $monthday_salary * $presentCount + $salary->perday/2 * $halfdayCount @endphp --}}
                        {{ number_format($currnt_day_salary, 2, '.', '') }}
                    </span>&nbsp;
                    + Overtime Salary
                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                        {{ number_format($totalOvertimeSalary, 2, '.', '') }}
                    </span>&nbsp;
                    = Total Salary
                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">

                        {{ number_format($currnt_day_salary + $totalOvertimeSalary, 2, '.', '') }}

                    </span>
                </div>
                <?php } else { ?>
                <div class="mt-3">
                    Total Salary
                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                        0
                    </span>&nbsp;
                    + Overtime Salary
                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                        0
                    </span>&nbsp;
                    = Total Salary
                    <span class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white font-medium">
                        0
                    </span>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 overflow-auto overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Name</th>
                        <th class="whitespace-nowrap text-center">Date</th>
                        <th class="whitespace-nowrap text-center">Clock In</th>
                        <th class="whitespace-nowrap text-center">Clock Out</th>
                        <th class="whitespace-nowrap text-center">Total Hours</th>
                        <th class="whitespace-nowrap text-center">Time Track</th>
                        <th class="text-center whitespace-nowrap text-center" colspan="3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        @if (!empty($attendance->user->getRoleNames()))
                            @foreach ($attendance->user->getRoleNames() as $role)
                                @php $role_name =  $role; @endphp
                            @endforeach
                        @endif
                        <!-- Use a form for each attendance row -->
                        <form action="{{ url('/attendance/update-status') }}" method="POST">
                            @csrf
                            <input type="hidden" name="attendanceId" value="{{ $attendance->id }}">
                            <tr class="intro-x">
                                <td class="whitespace-nowrap">
                                    <a
                                        href="{{ route('users.show', $attendance->user->id) }}">{{ $attendance->user->name ?? '' }}</a>
                                    @if ($attendance->late == 1)
                                        <a class="btn btn-sm attendance-status-btn btn-rounded-danger p-1">
                                            Late
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center whitespace-nowrap">{{ $attendance->date }}</td>
                                <td class="text-center whitespace-nowrap">{{ $attendance->clock_in }}</td>
                                <td class="text-center whitespace-nowrap">{{ $attendance->clock_out }}</td>
                                <td class="text-center whitespace-nowrap">{{ $attendance->total_hour }}</td>
                                <td class="text-center whitespace-nowrap"><a class=" text-theme-1" href="javascript:;"
                                        data-toggle="modal"
                                        data-target="#delete-confirmation-modal{{ $attendance->id }}">
                                        Details <i data-feather="chevrons-right" class="w-4 h-4 mr-1"></i></a></td>

                                <td class="table-report__action w-56 whitespace-nowrap">
                                    <div class="flex justify-center items-center mt-2">
                                        <!-- Use a submit button to trigger the form submission -->
                                        <button type="submit" name="status" value="present"
                                            class="btn btn-sm w-15 mr-1 mb-2 {{ $attendance->status === 'present' ? 'active btn-success' : 'btn-outline-success' }}">Present</button>
                                        <button type="submit" name="status" value="absent"
                                            class="btn btn-sm w-15 mr-1 mb-2 {{ $attendance->status === 'absent' ? 'active btn-danger' : 'btn-outline-danger' }}">Absent</button>
                                        @if ($role_name == Auth::user()->roles->first()->name)
                                        @else
                                            <button type="submit" name="status" value="half day"
                                                class="btn btn-sm w-20 mr-1 mb-2 {{ $attendance->status === 'half day' ? 'active btn-warning' : 'btn-outline-warning' }}">Half
                                                Day</button>
                                            @if($attendance->status == 'paid holiday' && $attendance->day == 'paid holiday')
                                                <button type="submit" name="status" value="paid holiday"
                                                class="btn btn-sm w-24 mr-1 mb-2 btn-rounded-orange">Paid Leave</button>
                                            @else   
                                                <button type="submit" name="status" value="paid holiday"
                                                class="btn btn-sm w-24 mr-1 mb-2 {{ $attendance->status === 'paid holiday' ? 'active btn-primary' : 'btn-outline-primary' }}">Paid Holiday</button>
                                            @endif
                                           

                                        @endif  
                                    </div>
                                </td>
                            </tr>
                        </form>
                        <!-- BEGIN: Delete Confirmation Modal -->
                        <div id="delete-confirmation-modal{{ $attendance->id }}" class="modal" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="p-5 ">
                                            <div class="text-xl mt-5">Time Track {{ $attendance->user->name }}</div>
                                            <div class="text-md mt-5">Date : {{ $attendance->date }}</div>
                                            <?php
                                            $pause_count = $attendance->pause_time ? count($attendance->pause_time) : 0;
                                            $resume_count = $attendance->resume_time ? count($attendance->resume_time) : 0;
                                            $pause_time_massage = [];
                                            if (isset($attendance->pause_time_massage)) {
                                                foreach (json_decode($attendance->pause_time_massage, true) as $message) {
                                                    $pause_time_massage[] = $message;
                                                }
                                            }
                                            ?>
                                            <div class="grid grid-cols-12 gap-6 mt-5 pb-3"
                                                style="border-bottom: 1px solid gray;">
                                                <div class="intro-y col-span-4">
                                                    Start Time
                                                </div>
                                                <div class="intro-y col-span-4">
                                                    Stop Time
                                                </div>
                                                <div class="intro-y col-span-4">
                                                    Stop Time Massage
                                                </div>
                                            </div>

                                            @for ($i = 0; $i < $resume_count; $i++)
                                                <div class="grid grid-cols-12 gap-6 mt-5">
                                                    <div class="intro-y col-span-4">
                                                        @if ($attendance->resume_time && $attendance->resume_time[$i])
                                                            {{ $attendance->resume_time[$i] }}
                                                        @endif
                                                    </div>
                                                    <div class="intro-y col-span-4">
                                                        @if (isset($attendance->pause_time) && isset($attendance->pause_time[$i]))
                                                            {{ $attendance->pause_time[$i] }}
                                                        @endif
                                                    </div>
                                                    <div class="intro-y col-span-4">
                                                        @if (isset($pause_time_massage[$i]))
                                                            {{ $pause_time_massage[$i] }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endfor


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
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.user-change-btn').click(function() {
                var user_id = $('#user_id').val();
                var month = $('#month').val();
                var year = $('#year').val();

                // Construct the URL with selected values and existing query parameters
                var url = "{{ url('attendance/user/') }}" + "/" + user_id +
                    "?month=" + month + "&year=" + year;


                window.location.href = url;
            });
        });
    </script>
@endsection
