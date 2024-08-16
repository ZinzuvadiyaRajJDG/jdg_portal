<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Salary;
use App\Models\Leave;
use App\Models\Overtime;
use App\Models\Attendance;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;

use Carbon\Carbon;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
     {
          $this->middleware('permission:manage-employee|employee-create|employee-edit|employee-show', ['only' => ['index','show']]);
          $this->middleware('permission:employee-create', ['only' => ['create','store']]);
          $this->middleware('permission:employee-edit', ['only' => ['edit','update']]);
     }

    public function index(Request $request): View
    {
        $query = User::role(['user','HR','Management Team']);
        if ($request->get('status') == "inactive") {
            $query->where('status', 'Inactive');
        }
        else 
        {
            $query->where('status', 'Active');
        }

        if($request->get('name'))
        {
            $name = $request->get('name');
            $query->where(function($q) use ($name) {
                $q->where('name', 'LIKE', "%$name%")
                  ->orWhere('email', 'LIKE', "%$name%");
            });
        }
        if ($request->get('date')) {
            $dateOption = $request->get('date');
            $query->orderBy('joining_date', $dateOption);
            $query->orderBy('id', 'ASC');
        }
        else
        {
            $query->orderBy('created_at', 'DESC');
            $query->orderBy('id','ASC');
        }
        $data = $query->get();
        // dd($data);
        return view('users.index',compact('data'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|numeric|digits:10',
            'birthdate' => 'required|date|before:2007-01-01',
            'position' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'shift_time' => 'required|string|max:10',
            'address' => 'required|string',
            'salary' => 'required|numeric',
            'password' => 'required|string|min:8',
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['status'] = 'Active';

        // add user and that role 
        $user = User::create($input);
        $user->assignRole('user');
        
        
        
       
        // Add salary code 
        $salary = new Salary;
        $salary->user_id = $user->id;
        $salary->total_attendance = null;

        $date = Carbon::createFromFormat('d-m-Y', date('d-m-Y'));
        $formattedDate = $date->format('d-m-Y');
        $month = $date->format('n');
        $year = $date->format('Y');
        
         // Add Attendance Code 

         $attendance_create = new Attendance;
         $attendance_create->user_id = $user->id;
         $attendance_create->date = $formattedDate;
         $attendance_create->status = 'absent';
         $attendance_create->day = 'full day';
         $attendance_create->late = 0;
         $attendance_create->month = $month;
         $attendance_create->year = $year;
         $attendance_create->save();

        // Attendance::create([
        //     'user_id' => $user->id,
        //     'date' => $formattedDate,
        //     'status' => 'absent',
        //     'day' => 'full day',
        //     'late' => 0,
        //     'month' => $month,
        //     'year' => $year,
        // ]);

    
    
        $salary->status = 'unpaid';
        $salary->salary = $request->salary;
        $salary->month = $month;
        $salary->year = $year;
        $salary->save();

        $currentDay = Carbon::now()->day;
        $firstDayOfMonth = Carbon::create($year, $month, 1);
        $lastDayOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
        $daysInMonth = $lastDayOfMonth->diffInDays($firstDayOfMonth) + 1;

        $salaries = Salary::where('user_id',$user->id)->get();
        
        $totalSalaryForDay = $salaries->sum(function ($item) {
            $salaryWithoutCommas = str_replace(',', '', $item->salary);
            return intval($salaryWithoutCommas);
        });
    
        $perDaySalary = $salaries->isNotEmpty() ? $totalSalaryForDay / $daysInMonth : 0;
        $perday = number_format($perDaySalary, 2, '.', '');
    
        $totalAttendanceCount = Attendance::where('user_id', $user->id)
            ->where('status', 'present')
            ->orWhere('status', 'paid holiday')
            ->count();
        
        $salary = Salary::where('user_id', $user->id)->first();

        if ($salary) {
            $salary->total_attendance = $totalAttendanceCount;
            $salary->perday = $perday;
            $salary->save();
        }

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;    

        $user = User::find($id);
        $salary = Salary::where('user_id',$id)
        ->where('month', $currentMonth)
        ->where('year', $currentYear)
        ->first();
        
        $totalPaidLeavesTakenYear = Leave::where('user_id', $id)
            ->where('day', 'paid holiday')
            ->where('year', $currentYear)
            ->get();


        $paid_leave = 0;
        foreach ($totalPaidLeavesTakenYear as $paidLeavesTotalDay) {
            $paid_leave += $paidLeavesTotalDay->total_day;
        }

        $totalLeavesTakenYear = Leave::where('user_id', $id)
            ->where('year', $currentYear)
            ->get();


        $leave_in_yare = 0;
        foreach ($totalLeavesTakenYear as $paidLeavesTotalDay) {
            $leave_in_yare += $paidLeavesTotalDay->total_day;
        }


        return view('users.show',compact('user','salary','paid_leave','leave_in_yare'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        // dd($userRole);
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'number' => 'required|numeric|digits:10',
            'birthdate' => 'required|date|before:2007-01-01',
            'position' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string',
            'password' => ''
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        // Attendance::where('user_id', $id)->delete();
        // Leave::where('user_id', $id)->delete();
        // Overtime::where('user_id', $id)->delete();
        // Salary::where('user_id', $id)->delete();
        User::find($id)->delete();

        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function changeStatus($id)
    {
        // dd($id);
        $user = User::findOrFail($id);
        
        if($user->status == "Active")
        {
            $data['status'] = "Inactive";
        }
        else
        {
            $data['status'] = "Active";
        }
        $user->status = $data['status'];
        $user->save();

        return redirect('users')->with('success', 'Employee Status updated successfully.');

    }

}