<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OTController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::id();


            if($request->get('month') && $request->get('year'))
            {
                $currentMonth = $request->get('month');
                $currentYear = $request->get('year');
            }   
            else
            {
                $currentYear = date("Y"); // Current year (e.g., 2023)
                $currentMonth = date("n");            
            }

            $overtimes = Overtime::with(['user'])
                    ->where('user_id', $user)
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->get();
            $totalOvertimeSalary = 0;
            foreach($overtimes as $overtime)
            {
                $totalOvertimeSalary += $overtime->overtime_salary; 
            }

            $currentDate = now()->toDateString(); // Get the current date in the format 'Y-m-d'

            $existing = Overtime::where('user_id', $user)
                ->whereDate('created_at', $currentDate)
                ->first();

            $checkInDisabled = $existing && $existing->clock_in !== null;
            $checkOutDisabled = $existing && $existing->clock_out !== null && $existing->clock_in !== null;


            // Admin Code
            $overtimesAdmin = Overtime::with(['user'])->where('date',$currentDate)->get();


            return view('ot.index', ['overtimesAdmin'=> $overtimesAdmin,'overtimes' => $overtimes,'checkInDisabled'=>$checkInDisabled,'checkOutDisabled'=>$checkOutDisabled, 'totalOvertimeSalary' => $totalOvertimeSalary]);
        
    }


    public function create(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $existingAttendance = $user->overtimes; // This should return a collection of related Post models.
        // $date = DateTime::createFromFormat('d M, Y', $request->date);
        // $formattedDate = $date->format('d-m-Y');
        // $existingAttendance = Attendance::where('user_id', $user)
        //     ->where('date', $request->date)
        //     ->first();
            // dd($existingAttendance);
        return view('ot.create',['user'=>$user,'existingAttendance'=>$existingAttendance]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $currentDateTime = Carbon::now();
        
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingAttendance = Overtime::where('user_id', $user->id)
           ->whereDate('created_at', $currentDateTime->toDateString()) // Filter by date only
            ->whereTime('created_at', '<=', $currentDateTime->toTimeString()) // Filter by time
            ->first();
        if($existingAttendance)
        {
            return redirect('overtime')->with('error','Your overtime added');
        }

        $clockInFullTime = Carbon::now('Asia/Kolkata');
        $clockInTime = $clockInFullTime->format('h:i A'); 

        $currentDate = now()->toDateString();

        $carbonDate = Carbon::parse($currentDate); // Convert the string to a Carbon instance

        $month = $carbonDate->format('n'); // Format the month
        $year = $carbonDate->format('Y');  // Format the year

                $overtime = new Overtime();
                $overtime->user_id = $user->id;
                $overtime->task_name = $request->task_name;
                $overtime->date = $currentDate;
                $overtime->clock_in = $clockInTime;
                $overtime->month = $month;
                $overtime->year = $year;
                $overtime->save();
        return redirect('overtime')->with('success', 'Overtime added successfully.');
    }

    public function clockoutdisplay()
    {
        $user = Auth::user();
        // dd(Auth::user());
        $currentDate = date('d M, Y');
        $existingAttendance = Overtime::where('user_id', $user->id)
            ->where('date', $currentDate)
            ->first();
            // dd($existingAttendance);

        return view('ot.clockout',['user'=>$user,'existingAttendance'=>$existingAttendance]);
    }

    public function clockout(Request $request)
    {
        $user = Auth::user();
        $currentDateTime = Carbon::now();
        
        $clockInFullTime = Carbon::now('Asia/Kolkata');
        $clockOutTime = $clockInFullTime->format('h:i A'); 

        $currentDate = now()->toDateString();

        $existingAttendance = Overtime::where('user_id', $user->id)
           ->whereDate('created_at', $currentDateTime->toDateString()) // Filter by date only
            ->whereTime('created_at', '<=', $currentDateTime->toTimeString()) // Filter by time
            ->first();
            // dd($existingAttendance);

        if ($existingAttendance) 
        {
                    $existingAttendance->update([
                        'clock_out' => $clockOutTime // Set the "clock_out" time
                    ]);
                    
                    $existing = Overtime::where('user_id', $user->id)
                       ->whereDate('created_at', $currentDateTime->toDateString()) 
                        ->first();
                        
                        $clockInTime = Carbon::parse($existing->clock_in);
                        $clockOutTime = Carbon::parse($existing->clock_out); 
            
                        $timeDuration = $clockOutTime->diff($clockInTime);
                        $overtimeSalary = 0; 
                        $roundedTimeDuration = $timeDuration->h.":".$timeDuration->i;

                        // dd($timeDuration);

                        
                // Check if the minutes part of timeDuration is greater than or equal to 45
                if($timeDuration->h != 0)
                {
                    if ($timeDuration->i >= 45) {
                        // Increment the hours part of timeDuration by 1
                        // dd("hello");
                        $timeDuration->h += 1;
                        // Reset the minutes part to 0
                        $timeDuration->i = 0;
                    }
                    $hours = $timeDuration->h;
                    // dd($hours);
                    $minutes = $timeDuration->i; 
                    // Salary Table 
                    $userSalary = Salary::where('user_id', $user->id)->first();
                    

                    $totalHours = $hours + ($minutes / 60);
                    $roundedTotalHours = intval($totalHours);
                    // dd($roundedTotalHours);
                    $perdaySalary = $userSalary->perday; // Assuming the salary amount is stored in the 'amount' column
                    $regularWorkingHours = 8;
                        
                    $hourlySalary = $perdaySalary / $regularWorkingHours;

                    $overtimeSalary = ceil($roundedTotalHours * $hourlySalary);
                }

            
                $existing->update([
                    // 'total_hour' => $roundedTotalHours,
                    'total_hour' => $roundedTimeDuration,
                    'overtime_salary' => $overtimeSalary,
                ]);
                return redirect('overtime')->with('success', 'Clock Out successful.');
        }
        else
        {   

            return redirect('overtime')->with('success', 'You need to clock in first.');
        }
        

    }

    public function show($user_id, Request $request)
    {
        if($request->get('month') == "" && $request->get('year') == "")
        {
            $currentMonth = date('n');
            $currentYear = date('Y');
        }
        else
        {   
            $currentMonth = $request->input('month');
            $currentYear = $request->input('year');
        }

        $overtimes = Overtime::with(['user'])
        ->where('user_id',$user_id)
        ->where('month', $currentMonth)
        ->where('year', $currentYear)
        ->get();

        $totalOvertimeSalary = 0;
        foreach($overtimes as $overtime)
        {
            $totalOvertimeSalary += $overtime->overtime_salary; 
        }
        
        return view('ot.show', ['overtimes' => $overtimes,'totalOvertimeSalary' => $totalOvertimeSalary,'user_id' => $user_id]);
        
    }

    public function destroy($id)
    {
        // Find the employee with the given ID
        $overtime = Overtime::findOrFail($id);

        // Delete the employee from the database
        $overtime->delete();

        // Redirect to the employees index page with a success message.
        return redirect('overtime')->with('success', 'overtime Data deleted successfully.');

    }
}
