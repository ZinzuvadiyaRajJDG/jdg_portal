<?php
$name = 'dashboard';
if($salaries)
{
    $month = $salaries->month;
    $year = $salaries->year;
    $total_salary = (isset($salaries))? $salaries->salary : '0';

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Calculate the salary per day
    $monthday_salary = ($daysInMonth > 0) ? $total_salary / $daysInMonth : 0;
    $salary_30day = $total_salary / 30;

    $currnt_total_day = $attendancePresentCount  + $attendanceAbsentCount + $attendancePaidHolidayCount + $attendanceHalfDayCount;
    $cut_salary = $attendanceAbsentCount * $salary_30day;
    $cut_half_salary = ($attendanceHalfDayCount * $salary_30day)/2;
    $currnt_day_salary = ($currnt_total_day * $monthday_salary) - $cut_salary - $cut_half_salary;                        
}

?>
@extends('layouts.app')
@section('content')
    @can('admin-dashboard')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            All Information About Employees
                        </h2>
                        <!-- <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> -->
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('users') }}">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-10"></i>
                                            <div class="ml-auto">
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $employeeActiveCount }}</div>
                                        <div class="text-base text-gray-600 mt-1">Total Employees</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <!-- <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('users?status=active') }}">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-9"></i>
                                            <div class="ml-auto">
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $employeeActiveCount }}</div>
                                        <div class="text-base text-gray-600 mt-1">Total Active Employees</div>
                                    </div>
                                </div>
                            </a>
                        </div> -->
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('attendance?status=present') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="user" class="report-box__icon text-theme-11"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $attendancePresentCountAdmin }}</div>
                                    <div class="text-base text-gray-600 mt-1">Today Present Employees</div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('attendance?status=absent') }}">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="user" class="report-box__icon text-theme-6"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{$attendanceAbsentCountAdmin}}</div>
                                    <div class="text-base text-gray-600 mt-1">Today Absent Employees</div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <a href="{{ url('users?status=inactive') }}">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-6"></i>
                                            <div class="ml-auto">
                                            </div>
                                        </div>
                                        <div class="text-3xl font-medium leading-8 mt-6">{{ $employeeInactiveCount }}</div>
                                        <div class="text-base text-gray-600 mt-1">Total Inactive Employees</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
            </div>
        </div>

    </div>
<!-- </div> -->
<!-- END: Content -->
    @endcan
    @can('user-dashboard')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            All Information About {{Auth()->user()->name}}
                        </h2>
                        <!-- <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a> -->
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="user-check" class="report-box__icon text-theme-10"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{$attendancePresentCount}}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Day Present</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="user-minus" class="report-box__icon text-theme-11"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $attendanceAbsentCount }}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Day Absent</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="user-plus" class="report-box__icon text-theme-12"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $attendanceHalfDayCount }}</div>
                                    <div class="text-base text-gray-600 mt-1">Total HalfDay</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="check-square" class="report-box__icon text-theme-10"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6">{{ $attendancePaidHolidayCount }}</div>
                                    <div class="text-base text-gray-600 mt-1">Total Paid Holiday</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 xxl:col-span-3 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-feather="credit-card" class="report-box__icon text-theme-10"></i>
                                        <div class="ml-auto">
                                        </div>
                                    </div>
                                    <div class="text-3xl font-medium leading-8 mt-6"> 
                                        @php
                                            $final_salary = $currnt_day_salary + $totalOvertimeSalary;
                                        @endphp
                                        @if($salaries) {{ ($final_salary < 0)? '0.00' : number_format($final_salary, 2, '.', '') }} @else 0.00 @endif</div>
                                    <div class="text-base text-gray-600 mt-1">Total Salary</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: General Report -->
            </div>
        </div>

    </div>
<!-- </div> -->
<!-- END: Content -->
    @endcan
@endsection
