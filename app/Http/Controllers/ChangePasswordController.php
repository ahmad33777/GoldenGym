<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    //


    public function changePasswordView()
    {
        return view('users.change-password');
    }

    public function changePasswordSave(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'new_password_confirmation' => 'required' 
 
        ], [
            'current_password.required'=>'حقل كلمة المرور الحالية مطلوب ',
            'new_password.required'=>'حقل كلمة المرور الجديدة مطلوب ',
            'new_password_confirmation.required'=>'حقل كلمة المرور الجديدة مطلوب ',
            'new_password.regex'=>'تنسيق كلمة المرور الجديد غير صالح ، يجب ان تحتوي على ارقام وحروف ورموز',
            'new_password.confirmed'=>'تأكيد كلمة المرور الجديدة غير متطابق.',    
            'new_password.min'=>'لا يمكن أن تكون اقل من 6 ',
        ]);
        $auth = Auth::user();

        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) {
            return back()->with('error', "Current Password is Invalid");
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->new_password) == 0) {
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->new_password);
        $status = $user->save();
        return back()->with('status', $status);
    }
}