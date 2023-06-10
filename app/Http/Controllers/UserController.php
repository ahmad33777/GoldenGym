<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Interval;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $users  =  User::with('roles')->get();
        // $users = User::with(['roles' => function ($q) {
        //     $q->where('name', '!=', 'admin');
        // }])->get();        // dd($users->toArray());
        $users = User::where('id', '!=', Auth::user()->id)->withCount('roles')->paginate(10);
        // $users  =  User::with('roles')->get();
        // $users  =  User::withCount('roles')->get();
        // dd($users->toArray());
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workDays = [
            'طول أيام الأسبوع',
            'السبت',
            'الأحد',
            'الأثنين',
            'الثلاثاء',
            'الأربعاء',
            'الخميس',
        ];
        $status =
            [
                'أعزب',
                'متزوج',
                'مطلق',
                'أرمل',
            ];
        $roles = Role::all();
        return view('users.create')->with(['roles' => $roles, 'status' => $status, 'workDays' => $workDays]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate(
            [
                'name' => 'required|string|min:10',
                'email' => 'required|email|unique:users',
                'phone' => 'required|min:10|numeric|unique:users',
                'workdays' => 'required',
                'worktimes' => 'required|',
                'marital_status' => 'nullable',
                'salary' => 'required|numeric',
                'image' => 'image|mimes:jpeg,png,jpg,gif',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب',
                'name.string' => 'يجب أن يكون الأسم حروف فقط',
                'email.min' => 'الأسم ثلاثي وفوق',
                'emial.required' => 'حقل البريد الإلكتروني مطلوب',
                'workdays.required' => 'هذا الحقل مطلوب',
                'worktimes.required' => 'هذا الحقل مطلوب',
                'salary.required' => 'هذا الحقل مطلوب',
                'salary.numeric' => 'الراتب  عبارة عن رقم',
                'password.min' => 'قصيرة جداًَ',
                'image.image' => 'يجب ان يكون الملف المختار صورة',
                'phone.required' => 'حقل الهاتف مطلوب.',
                'phone.unique'=>'تم أخذ الهاتف بالفعل',
                'email.unique'=>'لا يمكن أن يكون emil متكرر'

            ]
        );



        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->marital_status = $request->marital_status;
        $user->workdays = implode('-', $request->workdays);
        $user->Worktime = $request->worktimes;
        $user->salary = $request->salary;
        $user->password = Hash::make(123456);
        // to check if file exixts or not in the request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/employees/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $user->image = $path . $name;
        }


        // dd($user->toArray());
        $status = $user->save();
        // $user->assignRole($request->role);
        // Session::flash('status', $status);
        session()->flash('status', $status);
        // flash()->success('status', $status);
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workDays = [
            'طول أيام الأسبوع',
            'السبت',
            'الأحد',
            'الأثنين',
            'الثلاثاء',
            'الأربعاء',
            'الخميس',
        ];
        $status =
            [
                'أعزب',
                'متزوج',
                'مطلق',
                'أرمل',
            ];
        $roles = Role::all();
        $user = User::with('roles')->where('id', $id)->first();
        // dd($user->toArray());
        return view('users.edit')->with(['user' => $user, 'roles' => $roles, 'status' => $status, 'workDays' => $workDays]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|min:10',
                'email' => 'required|email|unique:users',
                'phone' => 'required|min:10|numeric|unique:users',
                'workdays' => 'required',
                'worktimes' => 'required|',
                'salary' => 'required|numeric',
                'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'image' => 'image|mimes:jpeg,png,jpg,gif',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب',
                'name.string' => 'يجب أن يكون الأسم حروف فقط',
                'email.min' => 'الأسم ثلاثي وفوق',
                'workdays.required' => 'هذا الحقل مطلوب',
                'worktimes.required' => 'هذا الحقل مطلوب',
                'salary.required' => 'هذا الحقل مطلوب',
                'salary.numeric' => 'الراتب  عبارة عن رقم',
                'password.required' => ' كلمة السر مطلوبة',
                'password.min' => 'قصيرة جداًَ',
                'image.image' => 'يجب ان يكون الملف المختار صورة'

            ]
        );
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->marital_status = $request->marital_status;
        $user->workdays = implode('-', $request->workdays);
        $user->Worktime = $request->worktimes;
        $user->salary = $request->salary;
        $user->password = Hash::make($request->password);
        // to check if file exixts or not in the request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/employees/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $user->image = $path . $name;
        }


        // dd($user->toArray());
        $status = $user->save();
        if ($user->role) {
            $user->removeRole($request->role);
            $user->assignRole($request->role);
        }
        // Session::flash('status', $status);
        session()->flash('statusUpdate', $status);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $role =  Role::findById($id)->delete();
        // return redirect()->back();
        $userDestroy = User::destroy($id);
        if ($userDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }


    public function search(Request $request)
    {
        //    dd('csajkbk');
        # code  for search process ...
        $search = $request->input('search');
        if ($search) {
            $users = User::where('id', '!=', Auth::user()->id)->withCount('roles')
                ->where(function ($query) use ($search) {
                    $query->orwhere('users.name', 'LIKE', "%{$search}%");
                    $query->orWhere('users.email', 'LIKE', "%{$search}%");
                    $query->orWhere('users.phone', 'LIKE', "%{$search}%");
                })->paginate(10);
            return view('users.index')->with('users', $users);
        } else {
            $users = User::where('id', '!=', Auth::user()->id)->withCount('roles')->paginate(30);
            return view('users.index')->with('users', $users);
        }


    }


    public function attendanceReport($id)
    {
        $user = User::find($id);

        return view('users.attendance-report')->with('user', $user);
    }

    public function searchattendanceReport(Request $request, $id)
    {



        $request->validate(
            [
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',
            ]
            ,
            [
                'startDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء تاريخًا بعد تاريخ البدء أو مساويًا له.',
            ]
        );

        $startDate = $request['startDate'];
        $endDate = $request['endDate'];

        // $user = User::with('attendances')->where('id', $id)->get();
        $user = User::where('id', $id)->first();
        $attendances = Attendance::where('user_id', $id)
            ->whereBetween('date', [$startDate, $endDate])->get();

        $totalTime = '00:00:00';
        $interval = CarbonInterval::seconds(0);
        foreach ($attendances as $attendance) {
            $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
        }
        $totalTime = $interval->format('%h:%I:%S');
        if ($startDate and $endDate) {
            return view('users.attendance-report')->with([
                'attendances' => $attendances,
                'user' => $user,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'totalTime' => $totalTime
            ]);
        } else {
            return view('users.attendance-report')->with('user', $user);
        }





    }


    public function financialReport($id)
    {


        $user = User::find($id);
        // dd($user->toArray());
        return view('users.financialReport')->with('user', $user);

    }

    public function financialReportSearch(Request $request, $id)
    {
 
        // dd($request->toArray());
        $request->validate(
            [
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',
            ]
            ,
            [
                'startDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء تاريخًا بعد تاريخ البدء أو مساويًا له حتى تكون عميلة البحث صحيحة',
            ]
        );
        $user = User::where('id', $id)->first();
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        $attendances = Attendance::where('user_id', $id)
            ->whereBetween('date', [$startDate, $endDate])->get();
        $numDays = Attendance::where('user_id', $id)
            ->whereBetween('date', [$startDate, $endDate])->count();

            // dd($numDays);
        $totalTime = '00:00:00';
        $interval = CarbonInterval::seconds(0);
        foreach ($attendances as $attendance) {
            $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
        }
        $totalTime = $interval->format('%h:%I:%S');
        if ($startDate and $endDate) {
            return view('users.financialReport')->with([
                'numDays' => $numDays,
                'startDate' => $startDate,
                'user' => $user,
                'endDate' => $endDate,
                'totalTime' => $totalTime ,
               
            ]);
        } else {
            return view('users.financialReport')->with('user', $user);
        }

    }

}