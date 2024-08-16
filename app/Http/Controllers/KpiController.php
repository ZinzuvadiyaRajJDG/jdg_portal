<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpipoint;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class KpiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manage-kpi|kpi-edit', ['only' => ['index']]);
        $this->middleware('permission:kpi-edit', ['only' => ['edit','update']]);
    }
    //
    public function index(Request $request)
    {
        $kpipoints = Kpipoint::with(['user'])->get();

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

        foreach($kpipoints as $kpipoint)
        {
            $total = 50;

            $id = $kpipoint->user_id;

            $attendancesAbsentCount = Attendance::with(['user'])
            ->where('user_id',$id)
            ->where('month',$currentMonth)
            ->where('year',$currentYear)
            ->where('status','absent')
            ->orderBy('created_at', 'asc')
            ->count(); 
    
            $attendancesLateCount = Attendance::with(['user'])
            ->where('user_id',$id)
            ->where('month',$currentMonth)
            ->where('year',$currentYear)
            ->where('late','1')
            ->orderBy('created_at', 'asc')
            ->count(); 

            $forgot_clockout_count = Attendance::where('user_id', $id)
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->where('clock_out', NULL)
            ->where('clock_in', '!=',NULL)
            ->count();

            if($attendancesAbsentCount > 2)
            {
                $total = $total - 10;
            }
            if($attendancesLateCount > 0)
            {
                $total = $total - (2 * $attendancesLateCount);
            }
            if($forgot_clockout_count > 0)
            {
                $total = $total - (2 * $forgot_clockout_count);
            }
            $kpipoint->regularity = $total;
        }

      

       

        return view('kpi.index', ['kpipoints' => $kpipoints]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ctm_points' => 'required',
        ]);

        $kpipoint = Kpipoint::find($id);

        if ($kpipoint) {
            $kpipoint->update([
                'ctm_points' => $request->ctm_points,
            ]);
        }
    
    
        return redirect()->route('kpipoints.index')->with('success','KPI Points updated successfully');
    }
    
}
