<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    // to show login laget
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // $validated = $request->validate(
        //     [
        //         'email' => 'required|string|email',
        //         'password' => 'required|string|min:3',
        //         'remember' => 'boolean'
        //     ],
        //     [
        //         'email.required' => 'رجاء إدخل البريد الإلكتروني ',
        //         'email.email' => 'البريدج المدخل غير صحيح',
        //         'password.required' => 'الرجاء , ادخل كلمة  المرورو ',

        //     ]
        // );
        // dd($validated);

        $validator = Validator(
            $request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string|min:3',
                'remember' => 'boolean'
            ],

        );

        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];


        if ($validator) {
            if (Auth::guard('web')->attempt($credentials, $request->get('remember'))) {
                $user = Auth::user();
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('error', 'الرجاء ادخال البريد الإلكتروني وكلمة المرورو بشكل صحيح');
            }
        } else {
            return redirect()->back()->with('error', 'الرجاء ادخال البريد الإلكتروني وكلمة المرورو بشكل صحيح');
        }
    }

    public function editProfile()
    {
    }
    public function updateProfile()
    {
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate(); // لابطال الجلسة
        return redirect()->route('admin.login');
    }
}