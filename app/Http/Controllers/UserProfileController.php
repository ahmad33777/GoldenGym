<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $status =
            [
                'أعزب',
                'متزوج',
                'مطلق',
                'أرمل',
            ];
        $user = User::find($id);
        return view('users.profile')->with(['user' => $user, 'status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate(
            [
                'name' => 'required|string|min:10',
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|min:10|numeric',
                'marital_status' => 'required|',
                'image' => 'image|mimes:jpeg,png,jpg,gif',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب',
                'name.string' => 'يجب أن يكون الأسم حروف فقط',
                'email.min' => 'الأسم ثلاثي وفوق',
                'email.required' => 'هذا الحقل مطلوب',
                'image.image' => 'يجب ان يكون الملف المختار صورة',
                'marital_status.required' => 'يجب ان تختار من ضمن الأختيارات'

            ]
        );
        $user = User::find($id);

        $user->name = $request->name;
        $user->email =  $request->email;
        $user->phone = $request->phone;
        $user->marital_status =  $request->marital_status;
        // to check if file exixts or not in the request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/employees/images/';
            $name  = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $user->image = $path . $name;
        }


        // dd($user->toArray());
        $status  = $user->save();
        // Session::flash('status', $status);
        session()->flash('statusUpdate', $status);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}