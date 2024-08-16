<?php

namespace App\Http\Controllers;

use App\Mail\LeaveApplicationMail;
use App\Models\Holiday;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LeaveApproveMail;
use App\Mail\LeaveRejectMail;
use Illuminate\Support\Facades\Validator;
use DateTime;


class LeaveController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->get('month') == "" && $request->get('year') == "") {
            $currentYear = now()->year;
            $currentMonth = now()->month;
        } else {
            $currentMonth = $request->input('month');
            $currentYear = $request->input('year');
        }

        $leavesAdmin = Leave::with('user')->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();



        $user = Auth::id();

        $totalPaidLeavesTakenYear = Leave::where('user_id', $user)
            ->where('day', 'paid holiday')
            ->where('year', $currentYear)
            ->get();


        $totalDayPaidLeaveYear = 0;
        foreach ($totalPaidLeavesTakenYear as $paidLeavesTotalDay) {
            $totalDayPaidLeaveYear += $paidLeavesTotalDay->total_day;
        }

        $leaves = Leave::with(['user'])
            ->where('user_id', $user)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get();

        return view('leaves.index', ['leavesAdmin' => $leavesAdmin, 'leaves' => $leaves, 'paid_leaves' => $totalDayPaidLeaveYear]);
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $leaveId = $request->input('leaveId');
        $status = $request->input('status');
        // dd($request->rejection_massage);

        // dd($leaveId);
        // Find the attendance record by ID
        $leave = Leave::find($leaveId);
        $user = User::find($leave->user_id);

        if ($leave) {
            $userId = $leave->user_id;

            // Update the status field in the database
            $leave->status = $status;
            // $leave->day = $day;

            if ($leave->status == "approved") {
                $leave->status = "approved";
                if($leave->day == "paid holiday" || $leave->day == "casual leave")
                {
                    $attendance_start_date = Attendance::where('date', $leave->start_leave_date)->where('user_id', $leave->user_id)->first();
                    if ($attendance_start_date) {
                        $attendance_start_date->day = 'paid holiday';
                        $attendance_start_date->status = 'paid holiday';
                        $attendance_start_date->update();
                    }

                    $attendance_end_date = Attendance::where('date', $leave->end_leave_date)->where('user_id', $leave->user_id)->first();
                    if ($attendance_end_date) {
                        $attendance_end_date->day = 'paid holiday';
                        $attendance_end_date->status = 'paid holiday';
                        $attendance_end_date->update();
                    }

                    // dd($attendance_start_date . "  |  " . $attendance_end_date);
                }
                else
                {
                    $attendance_multiple_leaves = Attendance::where('user_id', $leave->user_id)
                    ->where(function ($query) use ($leave) {
                        $query->whereBetween('date', [$leave->start_leave_date, $leave->end_leave_date])
                              ->orWhere('date', $leave->start_leave_date)
                              ->orWhere('date', $leave->end_leave_date);
                    })
                    ->get();
                    // dd($attendance_multiple_leave);
                    if ($attendance_multiple_leaves) {
                        foreach ($attendance_multiple_leaves as $attendance_multiple_leave) {
                            $attendance_multiple_leave->day = 'full day';
                            $attendance_multiple_leave->status = 'absent';
                            $attendance_multiple_leave->save();
                        }
                    }
                }
            }
            if ($leave->status == "rejected") {
                $leave->status = "rejected";
            }
            if ($request->rejection_massage) {
                $leave->rejection_massage = $request->rejection_massage;
            }
            $leave->save();

            if ($leave->status == "approved") {
                Mail::to($user->email)->send(new LeaveApproveMail($leave, $user->name));
            }
            if ($leave->status == "rejected") {
                Mail::to($user->email)->send(new LeaveRejectMail($leave, $user->name));
            }

            // dd("Status updated successfully");
            return back()->with('success', 'Status updated successfully');
        } else {
            // dd("Status record not found");
            return back()->with('error', 'Status record not found');
        }
    }


    public function create()
    {
        $user = auth()->user();
        return view('leaves.create',['user'=>$user]);
    }

    public function store(Request $request)
    {

        // $currentDateTime = Carbon::now();
        // $newDateTime = Carbon::now()->subDays(5);

        // // dd($currentDateTime);
        // dd($newDateTime);
        $endDateValidate = "";

        if($request->total_day > 1)
        {
            $endDateValidate =  function ($attribute, $value, $fail) use ($request) {
                $startLeaveDate = Carbon::parse($request->start_leave_date);
                $endLeaveDate = Carbon::parse($value);
                $diffInDays = $startLeaveDate->diffInDays($endLeaveDate) + 1; // Adding 1 to include both start and end days
                $errorMassage = 'Uh-oh! Duration Mismatch'. "\n\r". 'Ensure "Number of Days" Matches Start-End Difference';
                if ($diffInDays !== (int) $request->total_day) {
                    $fail($errorMassage);
                }
            };
        }

        $holidayDates = Holiday::all();
        // dd($holiday);
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer', // Assuming user_id is an integer
            'leave_heading' => 'required|string|max:255',
            'leave_reason' => 'required|min:100',
            'total_day' => 'integer|min:1',
            'day' => 'required|in:half day,full day,medical leave,emergency leave,paid holiday,casual leave',
            'start_leave_date' => 'required|after:today',
            'end_leave_date' => [
                'required_if:total_day,>1', // Only required if total_day is greater than 1
                 // Ensure it's a valid date
                 $endDateValidate
            ],
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd(Carbon::now());
        // dd($holiday[1]);

        // dd($holidayDates);

        $user = auth()->user();
        $startLeaveDate = Carbon::createFromFormat('d M, Y', $request->start_leave_date);
        $leaveMonth = $startLeaveDate->format('n');
        $leaveYear = $startLeaveDate->format('Y');

        $daysDifference = Carbon::now()->diffInDays($startLeaveDate);

        $startDateFormatted = $startLeaveDate->format('d-m-Y');
        $endDateFormatted = null;

        $userId = $user->id;

        if ($request->end_leave_date) {
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_leave_date);
            $endDateFormatted = $endDate->format('d-m-Y');
        }

        foreach($holidayDates as $holidayDate)
        {
            // dd($holidayDate['date'] . " | " .$startDateFormatted);
            if ($startDateFormatted == $holidayDate['date']) {
                return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
            }
            else
            {
                if($holidayDate['end_date'])
                {
                    if ($startDateFormatted == $holidayDate['end_date']) {
                        return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
                    }
                }
            }

            if ($request->end_leave_date) {
                if ($endDateFormatted == $holidayDate['date']) {
                    return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
                }
                else
                {
                    if($holidayDate['end_date'])
                    {
                        if ($endDateFormatted == $holidayDate['end_date']) {
                            return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
                        }
                    }
                }
            }

        }

        // Check if the leave type is 'full day' or 'half day'
        $isFullDayLeave = $request->day === 'full day';
        $isHalfDayLeave = $request->day === 'half day';
        $isMedicalDayLeave = $request->day === 'medical leave';
        $isEmergencyDayLeave = $request->day === 'emergency leave';

        // Check for any leave type that requires advance notice
        $requiresInstantNotice = $isFullDayLeave || $isHalfDayLeave || $isMedicalDayLeave || $isEmergencyDayLeave;

        // If required, check for the minimum notice period (1 week)
        if ($requiresInstantNotice) {
            $leave = new Leave();
            $leave->leave_heading = $request->leave_heading;
            $leave->leave_reason = $request->leave_reason;
            $leave->start_leave_date = $startDateFormatted;
            $leave->day = $request->day;
            $leave->end_leave_date = $endDateFormatted;
            if($request->day === 'full day' || $request->day === 'half day')
            {
                $leave->total_day = '1';
            }
            else
            {
                $leave->total_day = $request->total_day;
            }
            $leave->user_id = $user->id;
            $leave->month = $leaveMonth;
            $leave->year = $leaveYear;
            $leave->status = 'Pending';
            $leave->save();
// dd($user->name);

            Mail::to('hrmanager@justdigitalgurus.com')->send(new LeaveApplicationMail($leave, $user->name));
        }


        // Check if it's paid or casual leave
        $isPaidLeave = $request->day === 'paid holiday';

        // Check if the leave type requires at least 1 week notice
        $requiresAdvanceNotice = $isPaidLeave || $request->day === 'casual leave';

        if($requiresAdvanceNotice)
        {
            foreach ($holidayDates as $holidayDate) {
                $dateTime = DateTime::createFromFormat('d-m-Y', $holidayDate);

                if ($dateTime !== false) {
                    // Format the date in Y-m-d format
                    $formattedDate = $dateTime->format('Y-m-d');

                    // Convert to a Carbon instance
                    $formattedCarbonDate = Carbon::createFromFormat('Y-m-d', $formattedDate);

                    $allowedStartDate = Carbon::createFromFormat('Y-m-d', $formattedDate)->subDays(2);
                    $allowedEndDate = Carbon::createFromFormat('Y-m-d', $formattedDate)->addDays(2); // 2 days after the holiday

                    // dd($allowedEndDate);

                    $startLeaveDate = Carbon::createFromFormat('d M, Y', $request->start_leave_date);

                    if ($startLeaveDate->isBetween($allowedStartDate, $allowedEndDate)) {
                        return redirect()->back()->with('error', 'You cannot apply for leave within 2 days before or after a holiday.')->withInput();
                    }
                }
            }
        }
        if ($requiresAdvanceNotice && $daysDifference < 7) {


            return redirect()->back()->with('error', '1-week advance notice required for paid or casual leave requests.')->withInput();
        }


        $userId = $user->id;

        // Count paid leaves for the current month
        if ($isPaidLeave) {
            $paidLeavesTaken = Leave::where('user_id', $userId)
                ->where('day', 'paid holiday')
                ->where('year', $leaveYear)
                ->where('month', $leaveMonth)
                ->count();

            $totalPaidLeavesTaken = Leave::where('user_id', $userId)
                ->where('day', 'paid holiday')
                ->where('year', $leaveYear)
                ->where('month', $leaveMonth)
                ->get();

            $totalPaidLeavesTakenYear = Leave::where('user_id', $userId)
                ->where('day', 'paid holiday')
                ->where('year', $leaveYear)
                ->get();


            $totalDayPaidLeaveYear = 0;
            foreach ($totalPaidLeavesTakenYear as $paidLeavesTotalDay) {
                $totalDayPaidLeaveYear += $paidLeavesTotalDay->total_day;
            }

            $totalDayPaidLeave = 0;
            foreach($totalPaidLeavesTaken as $paidLeavesTotalDay)
            {
                $totalDayPaidLeave += $paidLeavesTotalDay->total_day;
            }

            if ($paidLeavesTaken >= 2 || $totalDayPaidLeaveYear >= 12 ||  $totalDayPaidLeave >= 2 || $request->total_day > 2) {
                return redirect()->back()->with('error', 'You can only apply for 2 paid leaves in a month and 12 paid leaves in a year.')->withInput();
            }

        }

        $startDateFormatted = $startLeaveDate->format('d-m-Y');
        $endDateFormatted = null;

        if ($request->end_leave_date) {
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_leave_date);
            $endDateFormatted = $endDate->format('d-m-Y');
        }

        if($requiresAdvanceNotice)
        {
            $leave = new Leave();
            $leave->leave_heading = $request->leave_heading;
            $leave->leave_reason = $request->leave_reason;
            $leave->start_leave_date = $startDateFormatted;
            $leave->day = $request->day;
            $leave->end_leave_date = $endDateFormatted;
            $leave->total_day = $request->total_day;
            $leave->user_id = $user->id;
            $leave->month = $leaveMonth;
            $leave->year = $leaveYear;
            $leave->status = 'Pending';
            $leave->save();

            Mail::to('hrmanager@justdigitalgurus.com')->send(new LeaveApplicationMail($leave, $user->name));

        }

        return redirect('leave')->with('success', 'Leave application submitted successfully.');
    }

    public function edit($id)
    {
        if (Auth::check())
        {
            $leave = Leave::findOrFail($id);
            $startDate = Carbon::createFromFormat('d-m-Y', $leave->start_leave_date);
            $startDateFormatted = $startDate->format('d M, Y');
            if(isset($leave->end_leave_date))
            {
                $endDate = Carbon::createFromFormat('d-m-Y', $leave->end_leave_date);
                $endDateFormatted = $endDate->format('d M, Y');
            }
            else
            {
                $endDateFormatted = '';
            }
            return view('leaves.edit', ['leave' => $leave,'startDate' => $startDateFormatted, 'endDate' => $endDateFormatted]);
        }
        else
        {
            return redirect('login');
        }
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'leave_heading' => 'required',
        //     'leave_reason' => 'required',
        //     'leave_date' => 'required|date',
        // ]);

        $leave = Leave::findOrFail($id);

        $endDateValidate = "";

        if($request->total_day > 1)
        {
            $endDateValidate =  function ($attribute, $value, $fail) use ($request) {
                $startLeaveDate = Carbon::parse($request->start_leave_date);
                $endLeaveDate = Carbon::parse($value);
                $diffInDays = $startLeaveDate->diffInDays($endLeaveDate) + 1; // Adding 1 to include both start and end days
                $errorMassage = 'Uh-oh! Duration Mismatch'. "\n\r". 'Ensure "Number of Days" Matches Start-End Difference';
                if ($diffInDays !== (int) $request->total_day) {
                    $fail($errorMassage);
                }
            };
        }

        $holidayDates = Holiday::all();
        // dd($holiday);
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required|integer', // Assuming user_id is an integer
            'leave_heading' => 'required|string|max:255',
            'leave_reason' => 'required|min:100',
            'total_day' => 'integer|min:1',
            'day' => 'required|in:half day,full day,medical leave,emergency leave,paid holiday,casual leave',
            'start_leave_date' => 'required|after:today',
            'end_leave_date' => [
                'required_if:total_day,>1', // Only required if total_day is greater than 1
                 // Ensure it's a valid date
                 $endDateValidate
            ],
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd(Carbon::now());
        // dd($holiday[1]);

        // dd($holidayDates);

        $user = auth()->user();
        $startLeaveDate = Carbon::createFromFormat('d M, Y', $request->start_leave_date);
        $leaveMonth = $startLeaveDate->format('n');
        $leaveYear = $startLeaveDate->format('Y');

        $daysDifference = Carbon::now()->diffInDays($startLeaveDate);

        $startDateFormatted = $startLeaveDate->format('d-m-Y');
        $endDateFormatted = null;

        $userId = $user->id;

        if ($request->end_leave_date) {
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_leave_date);
            $endDateFormatted = $endDate->format('d-m-Y');
        }

        foreach($holidayDates as $holidayDate)
        {
            // dd($holidayDate['date'] . " | " .$startDateFormatted);
            if ($startDateFormatted == $holidayDate['date']) {
                return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
            }
            else
            {
                if($holidayDate['end_date'])
                {
                    if ($startDateFormatted == $holidayDate['end_date']) {
                        return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
                    }
                }
            }

            if ($request->end_leave_date) {
                if ($endDateFormatted == $holidayDate['date']) {
                    return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
                }
                else
                {
                    if($holidayDate['end_date'])
                    {
                        if ($endDateFormatted == $holidayDate['end_date']) {
                            return redirect()->back()->with('error', 'You cannot apply for leave on a holiday.')->withInput();
                        }
                    }
                }
            }

        }

        // Check if the leave type is 'full day' or 'half day'
        $isFullDayLeave = $request->day === 'full day';
        $isHalfDayLeave = $request->day === 'half day';
        $isMedicalDayLeave = $request->day === 'medical leave';
        $isEmergencyDayLeave = $request->day === 'emergency leave';

        // Check for any leave type that requires advance notice
        $requiresInstantNotice = $isFullDayLeave || $isHalfDayLeave || $isMedicalDayLeave || $isEmergencyDayLeave;

        // If required, check for the minimum notice period (1 week)
        if ($requiresInstantNotice) {
            // $leave = new Leave();
            $leave->leave_heading = $request->leave_heading;
            $leave->leave_reason = $request->leave_reason;
            $leave->start_leave_date = $startDateFormatted;
            $leave->day = $request->day;
            $leave->end_leave_date = $endDateFormatted;
            if($request->day === 'full day' || $request->day === 'half day')
            {
                $leave->total_day = '1';
            }
            else
            {
                $leave->total_day = $request->total_day;
            }
            $leave->user_id = $user->id;
            $leave->month = $leaveMonth;
            $leave->year = $leaveYear;
            $leave->status = 'Pending';
            $leave->save();
// dd($user->name);

            Mail::to('hrmanager@justdigitalgurus.com')->send(new LeaveApplicationMail($leave, $user->name));
        }


        // Check if it's paid or casual leave
        $isPaidLeave = $request->day === 'paid holiday';

        // Check if the leave type requires at least 1 week notice
        $requiresAdvanceNotice = $isPaidLeave || $request->day === 'casual leave';

        if($requiresAdvanceNotice)
        {
            foreach ($holidayDates as $holidayDate) {
                $dateTime = DateTime::createFromFormat('d-m-Y', $holidayDate);

                if ($dateTime !== false) {
                    // Format the date in Y-m-d format
                    $formattedDate = $dateTime->format('Y-m-d');

                    // Convert to a Carbon instance
                    $formattedCarbonDate = Carbon::createFromFormat('Y-m-d', $formattedDate);

                    $allowedStartDate = Carbon::createFromFormat('Y-m-d', $formattedDate)->subDays(2);
                    $allowedEndDate = Carbon::createFromFormat('Y-m-d', $formattedDate)->addDays(2); // 2 days after the holiday

                    // dd($allowedEndDate);

                    $startLeaveDate = Carbon::createFromFormat('d M, Y', $request->start_leave_date);

                    if ($startLeaveDate->isBetween($allowedStartDate, $allowedEndDate)) {
                        return redirect()->back()->with('error', 'You cannot apply for leave within 2 days before or after a holiday.')->withInput();
                    }
                }
            }
        }
        if ($requiresAdvanceNotice && $daysDifference < 7) {


            return redirect()->back()->with('error', '1-week advance notice required for paid or casual leave requests.')->withInput();
        }


        $userId = $user->id;

        // Count paid leaves for the current month
        if ($isPaidLeave) {
            $paidLeavesTaken = Leave::where('user_id', $userId)
                ->where('day', 'paid holiday')
                ->where('year', $leaveYear)
                ->where('month', $leaveMonth)
                ->count();

            $totalPaidLeavesTaken = Leave::where('user_id', $userId)
                ->where('day', 'paid holiday')
                ->where('year', $leaveYear)
                ->where('month', $leaveMonth)
                ->get();

            $totalDayPaidLeave = 0;
            foreach($totalPaidLeavesTaken as $paidLeavesTotalDay)
            {
                $totalDayPaidLeave += $paidLeavesTotalDay->total_day;
            }

            if ($paidLeavesTaken >= 2 || $totalDayPaidLeave >= 2 || $request->total_day > 2) {
                return redirect()->back()->with('error', 'You can only apply for 2 paid leaves in a month.')->withInput();
            }

        }

        $startDateFormatted = $startLeaveDate->format('d-m-Y');
        $endDateFormatted = null;

        if ($request->end_leave_date) {
            $endDate = Carbon::createFromFormat('d M, Y', $request->end_leave_date);
            $endDateFormatted = $endDate->format('d-m-Y');
        }

        if($requiresAdvanceNotice)
        {
            // $leave = new Leave();
            $leave->leave_heading = $request->leave_heading;
            $leave->leave_reason = $request->leave_reason;
            $leave->start_leave_date = $startDateFormatted;
            $leave->day = $request->day;
            $leave->end_leave_date = $endDateFormatted;
            $leave->total_day = $request->total_day;
            $leave->user_id = $user->id;
            $leave->month = $leaveMonth;
            $leave->year = $leaveYear;
            $leave->status = 'Pending';
            $leave->save();

            Mail::to('hrmanager@justdigitalgurus.com')->send(new LeaveApplicationMail($leave, $user->name));

        }

        return redirect('leave')->with('success', 'Leave record updated successfully.');
    }
    public function destroy($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->delete();

        return redirect()->back()->with('success', 'Leave record deleted successfully.');
    }

    public function show($id, Request $request)
    {
        if($request->get('month') == "" && $request->get('year') == "")
        {
            $currentYear = now()->year;
        }
        else
        {
            $currentMonth = $request->input('month');
            $currentYear = $request->input('year');
        }

        $totalPaidLeavesTakenYear = Leave::where('user_id', $id)
            ->where('day', 'paid holiday')
            ->where('year', $currentYear)
            ->get();


        $totalDayPaidLeaveYear = 0;
        foreach ($totalPaidLeavesTakenYear as $paidLeavesTotalDay) {
            $totalDayPaidLeaveYear += $paidLeavesTotalDay->total_day;
        }

        $query = Leave::where('user_id',$id)->where('year',$currentYear);;
        if(isset($currentMonth))
        {
            $query->where('month',$currentMonth);
        }
        $leaves = $query->get();
        return view('leaves.show',['leaves' => $leaves, 'user_id' => $id, 'paid_leaves' => $totalDayPaidLeaveYear]);
    }

}
