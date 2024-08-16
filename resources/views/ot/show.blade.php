@php
$name = 'overtime';
$currentYear = date('Y');
$monthName = ['January','February','March','April','May','June','July','August','September','October','November','December']

@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">Employee Overtime Information</h2>

<div class="flex">
    <div style="width: 50%; flex-direction: column;" class="flex justify-end mb-3" >
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
                    @php
                        $totalMinutes = 0; // Initialize the total minutes to 0

                        foreach ($overtimes as $overtime) {
                            // Split the hour:minute string into hours and minutes
                            list($hours, $minutes) = explode(':', $overtime->total_hour);

                            // Convert hours to minutes and add to the total
                            $totalMinutes += ($hours * 60) + $minutes;
                        }

                        // Calculate total hours and remaining minutes
                        $totalHours = floor($totalMinutes / 60);
                        $remainingMinutes = $totalMinutes % 60;

                        // Display the total in the desired format
                        echo $totalHours . ':' . str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT);
                    @endphp
                </span>
            </h4>
        </div>
    </div>
    <div style="width: 50%" class="flex justify-end">

        <form method="GET" action="{{ url('overtime/'.$user_id) }}">
            <label for="" class="form-label">Monthly Overtime</label><br>
            <select name="month" id="year" class="form-control" style="width:150px;" required>
                <option value="">Select Month</option>
                @for ($month = 0; $month <= 11; $month++)
                <option value="<?= $month+1 ?>" {{ request('month') == $month+1 ? 'selected' : '' }}><?= $monthName[$month] ?>
                </option>
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
</div>
<div class="grid grid-cols-12 gap-6 mt-3">
    @foreach ($overtimes as $overtime)
        <div class="intro-y col-span-12 lg:col-span-6">
            <div class="intro-y box p-5">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $overtime->user->name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Task Name :</strong>
                            {{ $overtime->task_name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Date :</strong>
                            {{ $overtime->date }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Clock In Time :</strong>
                            {{ $overtime->clock_in }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Clock Out Time :</strong>
                            {{ $overtime->clock_out }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Total hour :</strong>
                            {{ $overtime->total_hour }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="form-group">
                            <strong>Overtime Salary :</strong>
                            {{ $overtime->overtime_salary }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection