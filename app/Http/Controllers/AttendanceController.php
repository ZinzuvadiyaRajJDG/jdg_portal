<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Overtime;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime; // Add this line at the beginning of your file
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;



class AttendanceController extends Controller
{
    //
    public function index(Request $request)
    {

        // Admin Side 
        $currentDate = date('d-m-Y');
        if ($request->get('status') == "present") {
            $attendancesAdmin = Attendance::with(['user'])
                ->where('date', $currentDate)
                ->where(function ($query) {
                    $query->where('status', 'present')
                          ->orWhere('status', 'half day')
                          ->orWhere('status', 'paid holiday');
                })
                ->get();
        } elseif ($request->get('status') == "absent") {
            $attendancesAdmin = Attendance::with(['user'])
                ->where('date', $currentDate)
                ->where('status', 'absent')
                ->get();
        } else {
            $attendancesAdmin = Attendance::with(['user'])
                ->where('date', $currentDate)
                ->get();
        }

        // dd($attendancesAdmin);



        // User Side 

        $user = Auth::id();

        $currentDate = now()->toDateString(); // Get the current date in the format 'Y-m-d'

        if ($request->get('month') && $request->get('year')) {
            $currentMonth = $request->get('month');
            $currentYear = $request->get('year');
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
        }
        $attendances = Attendance::with(['user'])
            ->where('user_id', $user)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->orderBy('created_at', 'asc')
            ->get();

        $existing = Attendance::where('user_id', $user)
            ->whereDate('created_at', $currentDate)
            ->first();


            $eqlTimeCount = 0;
            $clockInDisabled = 0;
            $clockOutDisabled = 0;
        if($existing)
        {
            $pause_count = ($existing->pause_time) ? count($existing->pause_time) : 0;
            $resume_count = ($existing->resume_time) ? count($existing->resume_time) : 0;
    
            $eqlTimeCount = $pause_count == $resume_count;
    
            $clockInDisabled = $existing && $existing->clock_in !== null;
            $clockOutDisabled = $existing && $existing->clock_out !== null;
            // dd($clockOutDisabled);
            if ($existing && $existing->clock_in == null) {
                $clockOutDisabled = true;
            }
    
            // dd($attendanceStatus);
    
    
        }
        return view('attendance.index', ['attendancesAdmin' => $attendancesAdmin, 'attendances' => $attendances, 'clockInDisabled' => $clockInDisabled, 'clockOutDisabled' => $clockOutDisabled, 'eqlTimeCount' => $eqlTimeCount]);
    }

    public function create(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $existingAttendance = $user->attendances;
        return view('attendance.create', ['user' => $user, 'existingAttendance' => $existingAttendance]);
    }

    public function store(Request $request)
    {
        // dd($request->date);
        $user = Auth::user();
        $full_date = new DateTime();
        $formatted_full_Date = $full_date->format('d M, Y');
        $currentDate = now()->toDateString(); 
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        // dd($request->date);
        // Convert the date to the desired format (YYYY-MM-DD)
        $date = DateTime::createFromFormat('d M, Y', $formatted_full_Date);
        $formattedDate = $date->format('d-m-Y');
        // dd($formattedDate);

        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $formattedDate)
            ->first();
        $existingAttendance->status = "present";


        $forgot_clockout_count = Attendance::where('user_id', $user->id)
        ->where('month', $currentMonth)
        ->where('year', $currentYear)
        ->where('clock_out', NULL)
        ->where('clock_in', '!=',NULL)
        ->count();

        
        if($forgot_clockout_count >= 3)
        {
            $forgot_clockout_data = Attendance::where('user_id', $user->id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('clock_out', NULL)
            ->where('clock_in', '!=',NULL)
            ->orderBy('id', 'desc')
            ->first();
            $forgot_clockout_data->status = "half day";
            $forgot_clockout_data->day = "half day";
            $forgot_clockout_data->save();  
            // dd($forgot_clockout_data);
        }

        // dd($forgot_clockout_count);

        $existingAttendance->late = 0;

        $clockInFullTime = Carbon::now('Asia/Kolkata');
        $clockInTime = $clockInFullTime->format('h:i A'); // Assuming the time format is HH:MM AM/PM
        // $clockInTime = "10:00 AM"; // Assuming the time format is HH:MM AM/PM
        $clockInHour = date('h', strtotime($clockInTime));
        $clockInMinute = date('i', strtotime($clockInTime));
        $ampm = date('A', strtotime($clockInTime));

        // Calculate the total minutes of clock-in time (convert to 24-hour format)
        if ($ampm === 'PM') {
            $clockInHour = $clockInHour + 12;
        }
        $totalClockInMinutes = ($clockInHour * 60) + $clockInMinute;
        
        list($shift_hours, $shift_minutes) = explode(':', $user->shift_time);
        $totalShiftMinutes = ($shift_hours * 60) + $shift_minutes + 10;

        // dd($totalShiftMinutes + 10);
        
        // Check if clock-in is later than 10:30 AM (630 minutes)
        if ($totalClockInMinutes > $totalShiftMinutes) {
            Session::flash('error', 'Oops! You are late');
            $existingAttendance->late = 1;
            
            $late_count = Attendance::where('user_id', $user->id)
            ->where('late', "1")
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->count();
            
            if($late_count >= 2)
            {
                $existingAttendance->status = "half day";
            }
            else
            {
                $existingAttendance->status = "present";
            }
            if (!$existingAttendance) {
                $attendance = new Attendance;
                $attendance->user_id = $user->id;
                $attendance->date = $formattedDate;
                $attendance->clock_in = $clockInTime;
                $attendance->status = "present";
                $pushtimeArray[] = $clockInTime;
                $attendance->resume_time = $pushtimeArray;
                $attendance->save();
                return redirect('attendance')->with('success', 'Attendance added successfully.');
            }
        }

        // If no existing attendance, create and save a new attendance record
        if (!$existingAttendance) {
            $attendance = new Attendance;
            $attendance->user_id = $user->id;
            $attendance->date = $formattedDate;
            $attendance->clock_in = $clockInTime;
            $attendance->save();
            return redirect('attendance')->with('success', 'Attendance added successfully.');
        }


        // Update the clock-in time for existing attendance
        $existingAttendance->clock_in = $clockInTime;
        
        $existingAttendance->resume_time = $clockInTime;
        $pushtimeArray[] = $clockInTime;
        $existingAttendance->resume_time = $pushtimeArray;
        $existingAttendance->save();

        return redirect('attendance')->with('success', 'Attendance added successfully.');
        ;
    }






    public function clockPause(Request $request)
    {
        $user = Auth::user();
        $currentTime = Carbon::now('Asia/Kolkata')->format('h:i A');
        $currentDateTime = Carbon::now();


        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $currentDateTime->toDateString())
            ->first();
            
        $pause_count = ($attendance->pause_time) ? count($attendance->pause_time) : 0;
        $resume_count = ($attendance->resume_time) ? count($attendance->resume_time) : 0;

        if($pause_count == $resume_count)
        {
            return redirect()->back()->with('error', 'Your time has been already paused.');
        }


        $pauseTimeArray = $attendance->pause_time;
        $pauseTimeArray[] = $currentTime;

        $pauseMassageArray = json_decode($attendance->pause_time_massage, true) ?? [];

        if($request->pause_massage != 'other')
        {
            $pauseMassageArray[] = $request->pause_massage;
        }
        else
        {
            $pauseMassageArray[] = $request->pause_massage_other;
        }


        $attendance->pause_time = $pauseTimeArray; // Update the pushtime field with the new array
        $attendance->pause_time_massage = json_encode($pauseMassageArray); // Update the pushtime field with the new array
        $attendance->save();

        return redirect()->back()->with('success', 'Clock Pause successful.');

    }
    public function clockResume()
    {
        $user = Auth::user();
        $currentTime = Carbon::now('Asia/Kolkata')->format('h:i A');
        $currentDateTime = Carbon::now();


        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $currentDateTime->toDateString())
            ->first();

        $pause_count = ($attendance->pause_time) ? count($attendance->pause_time) : 0;
        $resume_count = ($attendance->resume_time) ? count($attendance->resume_time) : 0;

        if($pause_count != $resume_count)
        {
            return redirect()->back()->with('error', 'Your time has been already Resumed.');
        }

        $pushtimeArray = $attendance->resume_time;
        $pushtimeArray[] = $currentTime;

        $attendance->resume_time = $pushtimeArray; // Update the pushtime field with the new array
        $attendance->save();

        return redirect()->back()->with('success', 'Clock Resume successful.');

    }


    public function clockoutdisplay()
    {
        $user = Auth::user();
        // dd(Auth::user());
        $currentDate = date('d M, Y');
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $currentDate)
            ->first();
        // dd($existingAttendance);
        return view('attendance.clockout', ['user' => $user, 'existingAttendance' => $existingAttendance]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $currentDateTime = Carbon::now();

        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        $pause_count = ($existingAttendance->pause_time) ? count($existingAttendance->pause_time) : 0;
        $resume_count = ($existingAttendance->resume_time) ? count($existingAttendance->resume_time) : 0;

        return view('attendance.show', ['attendance' => $existingAttendance, 'pause_count' => $pause_count, 'resume_count' => $resume_count, 'currentdate' => $currentDateTime]);
    }

    public function clockout(Request $request)
    {
        $user = Auth::user();
        $currentDateTime = Carbon::now();

        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $currentDateTime->toDateString())
            ->first();

        if ($existingAttendance) {
            // Retrieve the resume_time and pause_time arrays
            $resumeTimeArray = $existingAttendance->resume_time;
            $pauseTimeArray = $existingAttendance->pause_time;

            // Calculate the total duration between resume_time and pause_time
            $totalDuration = 0; // Initialize the total duration

            foreach ($resumeTimeArray as $key => $resumeTime) {
                // Check if there's a corresponding pause_time for each resume_time
                if (isset($pauseTimeArray[$key])) {
                    $resumeDateTime = Carbon::createFromFormat('h:i A', $resumeTime);
                    $pauseDateTime = Carbon::createFromFormat('h:i A', $pauseTimeArray[$key]);

                    // Calculate the duration between resume_time and pause_time
                    $duration = $pauseDateTime->diffInMinutes($resumeDateTime);

                    // Add the duration to the total duration
                    $totalDuration += $duration;
                }
            }

            // Convert the total duration to hours and minutes
            $hours = floor($totalDuration / 60);
            $minutes = $totalDuration % 60;

            // Format the total duration as a string
            $totalDurationString = $hours . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT);

            // Update the Attendance record with the total_duration and other information
            $existingAttendance->update([
                'clock_out' => Carbon::now('Asia/Kolkata')->format('h:i A'),
                'total_hour' => $totalDurationString,
                'status' => $hours <= 5 ? 'half day' : 'present',
                'day' => $hours <= 5 ? 'half day' : 'full day',
            ]);

            return redirect('attendance')->with('success', 'Clock Out successful.');
        } else {
            return redirect('attendance')->with('success', 'You need to clock in first.');
        }
    }


    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $attendanceId = $request->input('attendanceId');
        $status = $request->input('status');
        $day = $request->input('day');

        // dd($status . "|" . $day);
        // Find the attendance record by ID
        $attendance = Attendance::find($attendanceId);

        if ($attendance) {
            $userId = $attendance->user_id;

            // Update the status field in the database
            $attendance->status = $status;
            $attendance->day = $day;

            if($attendance->status == "half day")
            {
                $attendance->day = "half day";
            }
            if($attendance->status == "present")
            {
                $attendance->day = "full day";
            }
            if($attendance->status == "paid holiday")
            {
                $attendance->day = "full day";
            }
            $attendance->save();



            return back()->with('success' , 'Status updated successfully');

        } else {
            return back()->with('error' , 'Attendance record not found');

        }
    }

    public function adminShow($id, Request $request)
    {
        // $currentDate = now()->toDateString(); // Get the current date in the format 'Y-m-d'
        if($request->get('month') && $request->get('year'))
        {
            $currentMonth = $request->get('month');
            $currentYear = $request->get('year');
        }   
        else
        {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;    
        }
        $attendances = Attendance::with(['user'])
        ->where('user_id',$id)
        ->where('month',$currentMonth)
        ->where('year',$currentYear)
        ->orderBy('created_at', 'asc')
        ->get(); 
        
        

        $attendancesPresentCount = Attendance::with(['user'])
        ->where('user_id',$id)
        ->where('month',$currentMonth)
        ->where('year',$currentYear)
        ->where(function ($query) {
            $query->where('status', 'present')
                  ->orWhere('status', 'paid holiday');
        })
        ->orderBy('created_at', 'asc')
        ->count(); 


        $attendancesHalfdayCount = Attendance::with(['user'])
        ->where('user_id',$id)
        ->where('month',$currentMonth)
        ->where('year',$currentYear)
        ->where('status','half day')
        ->orderBy('created_at', 'asc')
        ->count(); 

        $attendancesAbsentCount = Attendance::with(['user'])
        ->where('user_id',$id)
        ->where('month',$currentMonth)
        ->where('year',$currentYear)
        ->where('status','absent')
        ->orderBy('created_at', 'asc')
        ->count(); 

        $salary = Salary::where('user_id',$id)
               ->where('month', $currentMonth)
               ->where('year', $currentYear)
               ->first();
        
        $overtimes = Overtime::with(['user'])
        ->where('user_id',$id)
        ->where('month', $currentMonth)
        ->where('year', $currentYear)
        ->get();


        $totalOvertimeSalary = 0;
        foreach($overtimes as $overtime)
        {
            $totalOvertimeSalary += $overtime->overtime_salary; 
        }

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();
        
        // *********** KPI Feature *********** 
        $attendancesKpiLateCount = Attendance::with(['user'])
        ->where('user_id',$id)
        ->where('month',$currentMonth)
        ->where('year',$currentYear)
        ->where('late', "1")
        ->orderBy('created_at', 'asc')
        ->count(); 

        // dd($attendancesKpiLateCount);
        // *********** KPI Feature *********** 

    return view('attendance.admin_show',['attendances'=>$attendances, 'user_id'=> $id, 'salary' => $salary,'presentCount' => $attendancesPresentCount,'halfdayCount'=>$attendancesHalfdayCount,'absentCount'=>$attendancesAbsentCount,'totalOvertimeSalary' => $totalOvertimeSalary, 'users' => $users]);

    }


}
