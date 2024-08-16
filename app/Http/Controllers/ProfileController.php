<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) 
        {
            $user = Auth::user();
            // dd($admin);
            return view('profile')->with(['user'=>$user]);
        }
        else
        {
            return redirect('login');
        }
    }

    public function edit_profile()
    {
        if (Auth::check()) 
        {
            $user = Auth::user();
            // dd($admin);
            return view('edit_profile')->with(['user'=>$user]);
        }
        else
        {
            return redirect('login');
        }
    }

    public function update(Request $request)
    {
        // Validate the incoming request data
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:admins',
        //     // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // Get the authenticated admin user
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|numeric|digits:10',
            'birthdate' => 'required|date',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the admin's name and email
        $user->name = $request->input('name');
        // $user->email = $request->input('email');
        $user->number = $request->input('number');
        $user->birthdate = $request->input('birthdate');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->zip_code = $request->input('zip_code');
        $user->address = $request->input('address');

        // Handle the profile image update (if provided)
        // if ($request->hasFile('image')) {
        //     // Store the new profile image in a designated directory
        //     $imagePath = $request->file('image')->store('profile_images', 'public');

        //     // Delete the previous profile image (if it exists)
        //     if ($admin->image && file_exists(public_path('storage/' . $admin->image))) {
        //         unlink(public_path('storage/' . $admin->image));
        //     }

        //     // Save the new image path in the database
        //     $admin->image = $imagePath;
        // }

        // Save the updated admin profile
        $user->save();

        // Redirect back with a success message
        return redirect('profile')->with('success', 'Profile updated successfully.');
    }

}