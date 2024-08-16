<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Careers;

class CareersConroller extends Controller
{
   public function user_index()
   {
        // $careers = Careers::all();
        // dd($careers);
        return view("index");
    } 
    public function index(Request $request)
    {
        $query = Careers::query(); // Rename the variable to avoid confusion

        if ($request->has('status') && $request->get('status') != "") {
            $status = $request->get('status');
            $query->where('status', $status);
        }

        if ($request->has('month') && $request->get('month') != "") {
            $monthInput = $request->get('month');
            
            $year = date('Y', strtotime($monthInput));
            $month = date('m', strtotime($monthInput));
    
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        $careers = $query->paginate(10)->appends($request->query());

        return view("careers.index", ['careers' => $careers]);
    } 
    
   public function store(Request $request)
   {
       
       // Validate the form data
       $this->validate($request, [
           'first_name' => 'required|string',
           'last_name' => 'required|string',
           'email' => 'required|email',
           'number' => 'required|string|regex:/^[0-9]{10}$/',
           'address' => 'required|string',
           'linkedin_url' => 'required|url',
           'position' => 'required|string',
           'experience' => 'required|string',
           'all_skills' => 'required|string',
           'reference' => 'nullable|string',
           'ctc' => 'required|string',
           'ectc' => 'required|string',
           'resume' => 'required|mimes:pdf',
       ]);


       // Store the data in the database
       $email = $request->input('email');
       $number = $request->input('number');
       
       // Check if a career with the same email or number already exists
       $existingCareer = Careers::where('email', $email)
                               ->orWhere('number', $number)
                               ->first();
        $career = new Careers();
        $career->first_name = $request->input('first_name');
        // dd($career->first_name);
        $career->last_name = $request->input('last_name');
        $career->email = $request->input('email');
        $career->number = $request->input('number');
        $career->address = $request->input('address');
        $career->linkedin_url = $request->input('linkedin_url');
        $career->position = $request->input('position');
        $career->exprerience = $request->input('experience');
        $career->skills = $request->input('all_skills');
        $career->reference = $request->input('reference') ?? null;
        $career->ctc = $request->input('ctc');
        $career->ectc = $request->input('ectc');
        // $career->previous_applied = $existingCareer ? "1" : "0";

       // Handle file upload
       if ($request->hasFile('resume')) {
           $file = $request->file('resume');
           $fileName = time() . '_' . $file->getClientOriginalName();
           $file->move(public_path('uploads/resumes'), $fileName);
           $career->resume = 'uploads/resumes/' . $fileName;
       }

       // Save the career application
       $career->save();

       // Redirect or return a response as needed
       return redirect('/')->with('success', 'Your application has been submitted successfully.');
   }

   public function show(string $id)
   {
        $careers = Careers::findOrfail($id);
        return view('careers.show', compact('careers'));
   }

    public function destroy($id)
    {
        Careers::findOrFail($id)->delete();
        return redirect()->back()->with('success','Data deleted successfully');
    }

   public function updateStatus(Request $request)
   {
        $career = Careers::findOrFail($request->id);
        $career->status = $request->status;
        $career->rejected_message = $request->rejected_message;
        $career->save();
        
        return response()->json(['message' => 'Status updated successfully'], 200);
   }
}
