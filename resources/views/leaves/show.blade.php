@php
$name = 'leave';
$currentYear = date('Y');
$monthName = ['January','February','March','April','May','June','July','August','September','October','November','December'];
@endphp
@extends('layouts.app')
@section('content')
<h2 class="intro-y text-lg font-medium mt-10">Leave Information</h2>


<form method="GET" action="{{ url('leave/'.$user_id) }}" class="mt-5">
    <label for="" class="form-label">Monthly Leave</label><br>
    <select name="month" id="year" class="form-control" style="width:150px;" required>
        <option value="">Select Month</option>
        @for ($month = 0; $month <= 11; $month++)
            <option value="<?= $month + 1 ?>" {{ request('month') == $month + 1 ? 'selected' : '' }}><?= $monthName[$month] ?>
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

<div class="grid grid-cols-12 gap-6 mt-3">
    @foreach ($leaves as $leave)
        
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $leave->user->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Leave Heading:</strong>
                        {{ $leave->leave_heading }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Leave Reason:</strong>
                        {!! $leave->leave_reason !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Total Day:</strong>
                        {{ $leave->total_day }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>Day:</strong>
                        @if( $leave->day == "paid holiday")
                            Paid Leave
                        @else
                            {{ $leave->day }} 
                        @endif

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>leave Start Date:</strong>
                        {{ $leave->start_leave_date }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="form-group">
                        <strong>leave End Date:</strong>
                        {{ $leave->end_leave_date }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection