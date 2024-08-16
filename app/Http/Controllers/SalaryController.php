<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\SalaryCreditMail;

class SalaryController extends Controller
{
    //
    public function index(Request $request)
    {
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

        $salaries = Salary::where('month', $currentMonth)->where('year', $currentYear)->get();

        // dd(count($salaries));
        if(count($salaries) > 0)
        {
            foreach($salaries as $salary)
            {

                $attendancesPresentCount = Attendance::with(['user'])
                ->where('user_id',$salary->user_id)
                ->where('month',$currentMonth)
                ->where('year',$currentYear)
                ->where(function ($query) {
                    $query->where('status', 'present')
                        ->orWhere('status', 'paid holiday');
                })
                ->orderBy('created_at', 'asc')
                ->count(); 


                $attendancesHalfdayCount = Attendance::with(['user'])
                ->where('user_id',$salary->user_id)
                ->where('month',$currentMonth)
                ->where('year',$currentYear)
                ->where('status','half day')
                ->orderBy('created_at', 'asc')
                ->count(); 

                $attendancesAbsentCount = Attendance::with(['user'])
                ->where('user_id',$salary->user_id)
                ->where('month',$currentMonth)
                ->where('year',$currentYear)
                ->where('status','absent')
                ->orderBy('created_at', 'asc')
                ->count(); 

                $overtimes = Overtime::with(['user'])
                ->where('user_id',$salary->user_id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get();

                $totalOvertimeSalary = 0;
                foreach($overtimes as $overtime)
                {
                    $totalOvertimeSalary += $overtime->overtime_salary; 
                }
            
                
                $month = $salary->month;
                $year = $salary->year;
                $total_salary = (isset($salary))? $salary->salary : '0';

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                // Calculate the salary per day
                $daysInMontharray[] = $daysInMonth;
                $total_salaryarray[] = $total_salary;

                $monthday_salary = ($daysInMonth > 0) ? $total_salary / $daysInMonth : 0;
                $salary_30day = $total_salary / 30;

                $currnt_total_day = $attendancesPresentCount + $attendancesAbsentCount + $attendancesHalfdayCount;
                $cut_salary = $attendancesAbsentCount * $salary_30day;
                $cut_half_salary = ($attendancesHalfdayCount * $salary_30day)/2;
                $currnt_day_salary = ($currnt_total_day * $monthday_salary) - $cut_salary - $cut_half_salary; 

                $salary->payable_amount = number_format($currnt_day_salary + $totalOvertimeSalary, 2, '.', '');
            }

            // dd($total_salaryarray);
        }
        else
        {
            $totalOvertimeSalary = 0;
            $attendancesPresentCount = 0;
            $attendancesHalfdayCount = 0;
            $attendancesAbsentCount = 0;
        }
         
        return view('salary.index',['salaries' => $salaries,'totalOvertimeSalary' => $totalOvertimeSalary,'presentCount' => $attendancesPresentCount,'halfdayCount'=>$attendancesHalfdayCount,'absentCount'=>$attendancesAbsentCount]);
    }

    public function create()
    {
        $user = User::all();
        return view('salary.create',['user'=>$user]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($month);
    
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'salary' => 'required|numeric',
            'month_year' => 'required|date_format:Y-m|before_or_equal:' . now()->format('Y-m'),
            'status' => 'required',
           
        ]);
    
        // Optionally, you can customize the error message for this rule
        $validator->setCustomMessages([
            'user_month_unique' => 'The combination of user and month_year must be unique.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        list($year, $month) = explode('-', $data['month_year']);
        $month = ltrim($month, '0');
        // Check if the user_id already exists in the Salary table
        $existingSalary = Salary::where('user_id', $request->user_id)
                        ->where('month', $month)    
                        ->where('year', $year)    
                        ->first();
        // dd($existingSalary);
        if ($existingSalary) {
            // If the user_id already exists, show an error message and redirect back
            return redirect('salary')->with('error', 'Salary already stored for this user.');
        }
    
        $salary = new Salary;
        $salary->user_id = $request->user_id;
        // $salary->name = $user->name; // If you want to store the user's name as well.
        $salary->total_attendance = $request->total_attendance;

        $date = Carbon::createFromFormat('d-m-Y', date('d-m-Y'));
        $formattedDate = $date->format('d-m-Y');
        $salary->status = $request->status;
        $salary->salary = $request->salary;
        $salary->month = $month;
        $salary->year = $year;
        $salary->save();
       
         // for store per day salary into table
        //  $currentMonth = Carbon::now()->month;
         $currentDay = Carbon::now()->day;
        //  $currentYear = Carbon::now()->year;
        //  dd($currentMonth . "" . $month);
        // //  dd($currentYear . "" . $year);

         $firstDayOfMonth = Carbon::create($year, $month, 1);

         // Create a Carbon instance for the last day of the current month
         $lastDayOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

         // Calculate the number of days between the first and last day of the current month
         $daysInMonth = $lastDayOfMonth->diffInDays($firstDayOfMonth) + 1;

         // dd($daysInMonth);

         $salaries = Salary::where('user_id',$request->user_id)
         ->get();
         
         $totalSalaryForDay = $salaries->sum(function ($item) {
             $salaryWithoutCommas = str_replace(',', '', $item->salary);
             return intval($salaryWithoutCommas);
         });
        //  dd($totalSalaryForDay / $daysInMonth);

         $perDaySalary = $salaries->isNotEmpty() ? $totalSalaryForDay / $daysInMonth : 0;
         // dd($perDaySalary);
         $perday = number_format($perDaySalary, 2, '.', '');
         // dd($perday);
         // per day salary end

         // store total attendance and per day salary code 
         $totalAttendanceCount = Attendance::where('user_id', $request->user_id)
             ->where('status', 'present')
             ->orWhere('status', 'paid holiday')
             ->count();
            //  dd($totalAttendanceCount);
         $salary = Salary::where('user_id', $request->user_id)->first();
         // dd($salary);

         if ($salary) {
             $salary->total_attendance = $totalAttendanceCount;
             $salary->perday = $perday;
             $salary->save();
         }

        // Redirect to the employees index page with a success message.
        return redirect('salary')->with('success', 'Salary created successfully.');
    }

    public function updateSalaryStatus(Request $request)
    {
        $salaryId = $request->input('salary_id');
        $newStatus = $request->input('status');
        $message = $request->input('message');
        $userEmail = $request->input('userEmail');

        // Update the salary status in the database
        $salary = Salary::findOrFail($salaryId);
        // $salary->status = 'unpaid';
        $salary->status = $newStatus;
        $salary->save();

        Mail::to($userEmail)->send(new SalaryCreditMail($message));


        return response()->json(['message' => 'Salary status updated successfully.']);
    }

    public function edit($id)
    {
        // Retrieve the salary with the given ID from the database
        $salary = Salary::findOrFail($id);
        return view('salary.edit', compact('salary'));
    }

    public function update(Request $request, $id)
    {
        // Retrieve the salary with the given ID from the database
        $salary = Salary::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'salary' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $salaryWithoutCommas = str_replace(',', '', $request->salary);
        $totalsalary = intval($salaryWithoutCommas);
        // $totalSalaryForDay = $salary->sum(function ($item) {
        //         $salaryWithoutCommas = str_replace(',', '', $item->salary);
        //         return intval($salaryWithoutCommas);
        //     });
        //     dd($totalSalaryForDay);
        
            $daysInMonth = now()->daysInMonth; // Get the days in the current month
            $perDaySalary = $totalsalary / $daysInMonth;
            $perday = number_format($perDaySalary, 2, '.', '');
            $salary->salary = $request->input('salary'); 
            $salary->status = $request->input('status'); 
            $salary->perday = $perday;  
            $salary->save();
            // dd($perday);
            // dd($perday);
        // Update the salary record in the database
        // $salary->update([
        //     'name' => $request->input('name'),
        //     'salary' => $request->input('salary'),
        //     'perday' => $perday
        //     ]);
            
        // Redirect to the index page after successful update
        return redirect()->route('salary.index')->with('success', 'Salary updated successfully.');
    }

    public function destroy($id)
    {
        Salary::find($id)->delete();
        return redirect()->route('salary.index')
                        ->with('success','Salary deleted successfully');
    }
}
