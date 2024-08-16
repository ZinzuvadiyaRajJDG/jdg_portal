<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:manage-holiday|holiday-create|holiday-edit|holiday-delete', ['only' => ['index']]);
         $this->middleware('permission:holiday-create', ['only' => ['create','store']]);
         $this->middleware('permission:holiday-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:holiday-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->get('year') == "" && $request->get('month') == "")
        {
            $currentYear = now()->year;
            $holidays = Holiday::where('year',$currentYear)->get();
        }
        else
        {
            $currentYear = $request->input('year');
            $currentmonth = $request->input('month');
            $holidays = Holiday::where('year',$currentYear)->where('month',$currentmonth)->get();
        }

        // Retrieve all holidays from the database and pass them to the view
        return view('holiday.index', compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('holiday.create');
    }

    public function store(Request $request)
    {

        $endDateValidate = "";

        if($request->day > 1)
        {
            $endDateValidate =  function ($attribute, $value, $fail) use ($request) {
                $startLeaveDate = Carbon::parse($request->date);
                $endLeaveDate = Carbon::parse($value);
                $diffInDays = $startLeaveDate->diffInDays($endLeaveDate) + 1; // Adding 1 to include both start and end days

                if ($diffInDays !== (int) $request->day) {
                    $fail('The difference between start and end leave dates should match the Number of Days value.');
                }
            };
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'day' => 'required',
            'date' => 'required|date',
            'end_date' => [
                'required_if:day,>1', 
                 $endDateValidate
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formattedDate = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('d-m-Y');
        $formattedEndDate = null;
        if($request->input('end_date'))
        {
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->format('d-m-Y');
        }
        $monthAndYear = Carbon::createFromFormat('Y-m-d', $request->input('date'));
        $holidayMonth = $monthAndYear->format('n');
        $holidayYear = $monthAndYear->format('Y');
        // dd($request->input('day'));

        // Create a new holiday record in the database
        $holiday = new Holiday();
        $holiday->name = $request->input('name'); 
        $holiday->day = $request->input('day'); 
        $holiday->date = $formattedDate; 
        $holiday->end_date = $formattedEndDate; 
        $holiday->month = $holidayMonth; 
        $holiday->year = $holidayYear; 
        $holiday->save();
        
        // Holiday::create([
        //     'name' => $request->input('name'),
        //     'day' => $request->input('day'),
        //     'date' => $formattedDate,
        //     'end_date' => $formattedEndDate,
        //     'month' => $holidayMonth,
        //     'year' => $holidayYear
        //     // Add any other fields you want to save
        // ]);

        // Redirect to the index page after successful creation
        return redirect()->route('holiday.index')->with('success','Holiday created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the holiday with the given ID from the database
        $holiday = Holiday::findOrFail($id);
        // dd($holiday);
        return view('holiday.edit', compact('holiday'))->with('success','Holiday updated successfully');
    }

    public function update(Request $request, $id)
    {
        $endDateValidate = "";

        if($request->day > 1)
        {
            $endDateValidate =  function ($attribute, $value, $fail) use ($request) {
                $startLeaveDate = Carbon::parse($request->date);
                $endLeaveDate = Carbon::parse($value);
                $diffInDays = $startLeaveDate->diffInDays($endLeaveDate) + 1; // Adding 1 to include both start and end days

                if ($diffInDays !== (int) $request->day) {
                    $fail('The difference between start and end leave dates should match the Number of Days value.');
                }
            };
        }

        // dd($request->input('day'));
        

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'day' => 'required',
            'date' => 'required|date',
            'end_date' => [
                'required_if:day,>1', 
                 $endDateValidate
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formattedDate = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('d-m-Y');
        $formattedEndDate = null;
        if($request->input('end_date'))
        {
            $formattedEndDate = Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->format('d-m-Y');
        }
        $monthAndYear = Carbon::createFromFormat('Y-m-d', $request->input('date'));
        $holidayMonth = $monthAndYear->format('n');
        $holidayYear = $monthAndYear->format('Y');
        $holiday = Holiday::findOrFail($id);
        
        $holiday->name = $request->input('name');
        $holiday->day = $request->input('day');
        $holiday->date = $formattedDate;
        $holiday->end_date = $formattedEndDate;
        $holiday->month = $holidayMonth;
        $holiday->year = $holidayYear;

        $holiday->update();

        // Redirect to the index page after successful update
        return redirect()->route('holiday.index')->with('success','Holiday updated successfully');;
    }

    public function destroy($id)
    {
        // Retrieve the holiday with the given ID from the database
        $holiday = Holiday::findOrFail($id);

        // Delete the holiday record from the database
        $holiday->delete();

        // Redirect to the index page after successful deletion
        return redirect()->route('holiday.index');
    }
}
