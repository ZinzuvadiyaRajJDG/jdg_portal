<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function displaychangepassword(){
        if (Auth::check()) 
        {
            return view('changepassword');
        }
        else
        {
            return redirect('login');
        }
    }

     public function changePassword(Request $request)
     {
        // dd($request->all());
        //  $request->validate([
        //      'old_password' => 'required',
        //      'new_password' => 'required',
        //  ]);

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|different:old_password',
            'old_password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

         $user = Auth::user();
        //  dd($user);
         if (Hash::check($request->old_password, $user->password)) {
             // Old password matches, update the new password
             $user->update([
                 'password' => Hash::make($request->new_password),
             ]);

             return redirect('change_password')->with('success', 'Password changed successfully.');
         }

         return redirect('change_password')->with('error', 'Old password is incorrect.');
     }
}
