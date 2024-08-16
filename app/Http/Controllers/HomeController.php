<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
            $currentMonth = Carbon::now()->month;
            $currentDay = Carbon::now()->day;
            $currentYear = Carbon::now()->year;
            // dd($currentMonth);

            $attendancePresentCount = Attendance::with(['user'])
                        ->where('status', 'present')
                        ->where('user_id',$user->id)
                        ->where('month',$currentMonth)
                        ->where('year',$currentYear)
                        ->count();
            $attendancePaidHolidayCount = Attendance::with(['user'])
                        ->where('status', 'paid holiday')
                        ->where('user_id',$user->id)
                        ->where('month',$currentMonth)
                        ->where('year',$currentYear)
                        ->count();
            $attendanceAbsentCount = Attendance::with(['user'])
                        ->where('status', 'absent')
                        ->where('user_id',$user->id)
                        ->where('month',$currentMonth)
                        ->where('year',$currentYear)
                        ->count();
            $attendanceHalfDayCount = Attendance::with(['user'])
                        ->where('status', 'half day')
                        ->where('user_id',$user->id)
                        ->where('month',$currentMonth)
                        ->where('year',$currentYear)
                        ->count();


            $firstDayOfMonth = Carbon::create($currentYear, $currentMonth, 1);

            $lastDayOfMonth = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();

            $daysInMonth = $lastDayOfMonth->diffInDays($firstDayOfMonth) + 1;

            // dd($daysInMonth);

            $salaries = Salary::where('user_id',$user->id)
                    ->where('month', $currentMonth)
                    ->where('year', $currentYear)
                    ->first();
            // dd($salaries);
            
            // dd($todaySalary);
            // dd($todaySalary);

            $currentYear = date("Y"); // Current year (e.g., 2023)
            $currentMonth = date("n");
    
            $overtimes = Overtime::with(['user'])
                ->where('user_id',$user->id)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get();

            $totalOvertimeSalary = 0;
            foreach($overtimes as $overtime)
            {
                $totalOvertimeSalary += $overtime->overtime_salary; 
            }






            $currentDate = date('d-m-Y');
            
            $employeeActiveCount = User::role(['user','HR','Management Team'])->where('status','Active')->count();
            $employeeCount = User::role(['user','HR','Management Team'])->count();
            $employeeInactiveCount = User::role(['user','HR','Management Team'])->where('status','Inactive')->count();
            // $attendancePresentCount = Attendance::where('status', 'Present')->where('date',$currentDate)->count();
            $attendancePresentCountAdmin = Attendance::where(function($query) use ($currentDate) {
                $query->where('status', 'Present')
                    ->orWhere('status', 'Half Day')
                    ->orWhere('status', 'paid holiday');
            })
            ->where('date', $currentDate)
            ->count();
            $attendanceAbsentCountAdmin = Attendance::where('status', 'Absent')->where('date',$currentDate)->count();
            $attendanceCount = Attendance::count();

            // dd($OvertimeCountsByUser);
            return view('home',[
                'employeeCount'=>$employeeCount,
                'employeeActiveCount'=>$employeeActiveCount,
                'employeeInactiveCount'=>$employeeInactiveCount,
                'attendancePresentCountAdmin'=>$attendancePresentCountAdmin,
                'attendanceAbsentCountAdmin'=>$attendanceAbsentCountAdmin,
                'attendanceCount'=>$attendanceCount,
                'attendancePresentCount'=>$attendancePresentCount,
                'attendanceAbsentCount'=>$attendanceAbsentCount,
                'attendancePaidHolidayCount'=>$attendancePaidHolidayCount,
                'attendanceHalfDayCount'=>$attendanceHalfDayCount,
                'salaries'=>$salaries,
                'totalOvertimeSalary' => $totalOvertimeSalary, 
                'user_id' => $user->id]);

    }
}
