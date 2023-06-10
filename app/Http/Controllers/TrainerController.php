<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\schedule;
use App\Models\TrainerAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\CarbonInterval;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = schedule::all();
        $trainers = Trainer::with('schedules')->get();
        $status =
            [
                'أعزب',
                'متزوج',
                'مطلق',
                'أرمل',
            ];
        return view('trainers.index')->with(['status' => $status, 'schedules' => $schedules, 'trainers' => $trainers]);
    }





    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'name' => ['required', 'string', 'min:5'],
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|min:10|numeric',
                'image' => 'image|mimes:jpeg,png,jpg,gif|nullable',
                'age' => 'min:16|numeric|nullable',
                'marital_status' => 'in:أعزب,مطلق,متزوج,أرمل',
                'schedule' => 'required|not_in:0',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب ',
                'name.alpha' => 'يجب أن يكون الأسم عبارة عم حروف ؟؟',
                'name.min' => 'يجب أن يكون الأسم ثلاثي ',
                'name.string' => 'يجب أن يكون حروق',
                'email.required' => 'هذا الحقل مطلوب ',
                'email.email' => 'خطأفي التنسيق',
                'phone.required' => 'هذا الحقل مطلوب ',
                'phone.min' => ' المدخل غير صحيح ؟؟  ىقم الهاتف مكون من 10 أرقام كحد أدنى',
                'phonr.numeric' => 'المدخل غير صحيح ؟؟',
                'image.image' => 'المدخل غير صحيح ؟؟  اختار صورة ',
                'image.mimes' => 'خطأ في نوع الطورة يجب أن تكون الصورة ضمن الأمتداد المتاح ؟',
                'age.min' => 'هل العمر صحيح ؟؟  لا يمكن أن يكون العمر أقل من 16 سنة ',
                'age.numeric' => 'خطأ في المدخل ؟ يجب أن يكون رقم ',
                'marital_status.in' => 'الأختيار غير متاح ضمن الأختيارات ',
                'schedule.required' => 'هذا الحقل مطلوب ',
                'schedule.not_in' => 'المدخل غير صحيح ؟؟',
            ]
        );
        // dd($request->all());

        $trainer = new Trainer();
        $trainer->name = $request->name;
        $trainer->email = $request->email;
        $trainer->phone = $request->phone;
        $trainer->age = $request->age;
        $trainer->marital_status = $request->marital_status;
        // password  123456 deffult value to all trainer
        $trainer->password = Hash::make(123456);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/trainers/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $trainer->image = $path . $name;
        }
        $status = $trainer->save();

        if ($request->schedule) {
            $schedule = schedule::where('name', $request->schedule)->first();
            $trainer->schedules()->attach($schedule->id);
        }


        session()->flash('status', $status);
        return redirect()->route('trainers.index');





    }



    public function edit($id)
    {
        $trainer = Trainer::with('schedules')->find($id);
        return response()->json([
            'status' => 200,
            'trainer' => $trainer
        ]);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'min:5'],
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|min:10|numeric',
                'image' => 'image|mimes:jpeg,png,jpg,gif|nullable',
                'age' => 'min:16|numeric|nullable',
                'marital_status' => 'in:أعزب,مطلق,متزوج,أرمل',
                'schedule' => 'required|not_in:0',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب ',
                'name.alpha' => 'يجب أن يكون الأسم عبارة عم حروف ؟؟',
                'name.min' => 'يجب أن يكون الأسم ثلاثي ',
                'name.string' => 'يجب أن يكون حروق',
                'email.required' => 'هذا الحقل مطلوب ',
                'email.email' => 'خطأفي التنسيق',
                'phone.required' => 'هذا الحقل مطلوب ',
                'phone.min' => ' المدخل غير صحيح ؟؟  ىقم الهاتف مكون من 10 أرقام كحد أدنى',
                'phonr.numeric' => 'المدخل غير صحيح ؟؟',
                'image.image' => 'المدخل غير صحيح ؟؟  اختار صورة ',
                'image.mimes' => 'خطأ في نوع الطورة يجب أن تكون الصورة ضمن الأمتداد المتاح ؟',
                'age.min' => 'هل العمر صحيح ؟؟  لا يمكن أن يكون العمر أقل من 16 سنة ',
                'age.numeric' => 'خطأ في المدخل ؟ يجب أن يكون رقم ',
                'marital_status.in' => 'الأختيار غير متاح ضمن الأختيارات ',
                'schedule.required' => 'هذا الحقل مطلوب ',
                'schedule.not_in' => 'المدخل غير صحيح ؟؟',
            ]
        );

        $trainer_id = $request['trainerID'];
        $trainer = Trainer::with('schedules')->find($trainer_id);
        $trainer->name = $request->name;
        $trainer->email = $request->email;
        $trainer->phone = $request->phone;
        $trainer->age = $request->age;
        $trainer->marital_status = $request->marital_status;
        // password  123456 deffult value to all trainer
        $trainer->password = Hash::make(123456);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uplodes/trainers/images/';
            $name = time() + rand(1, 1000000000) . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->put($path . $name, file_get_contents($image));
            $trainer->image = $path . $name;
        }
        // update All Data 
        $status = $trainer->update();
        if ($request->schedule) {
            if ($trainer->schedules->first()->name !== $request->schedule) {
                $schedule = schedule::where('name', $request->schedule)->first();
                $trainer->schedules()->attach($schedule->id);
            }
        }


        session()->flash('statusUpdate', $status);
        return redirect()->route('trainers.index');
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
        $trainerDestroy = Trainer::destroy($id);
        if ($trainerDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        // return $search ;

        if ($search) {
            $trainers = Trainer::
                where(function ($query) use ($search) {
                    $query->orwhere('trainers.name', 'LIKE', "%{$search}%");
                    $query->orWhere('trainers.email', 'LIKE', "%{$search}%");
                    $query->orWhere('trainers.phone', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('schedules', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->orderBy('id')
                ->get();
            //  dd($trainers->toArray());

            // return $users;
            $status =
                [
                    'أعزب',
                    'متزوج',
                    'مطلق',
                    'أرمل',
                ];

            $schedules = schedule::all();

            return view('trainers.index')->with(['trainers' => $trainers, 'schedules' => $schedules, 'status' => $status]);
        } else {
            $schedules = schedule::all();

            $trainers = Trainer::with('schedules')->get();
            // dd($trainers->toArray());
            $status =
                [
                    'أعزب',
                    'متزوج',
                    'مطلق',
                    'أرمل',
                ];
            return view('trainers.index')->with(['status' => $status, 'schedules' => $schedules, 'trainers' => $trainers]);

        }


    }




    public function attendanceReport(Request $request, $trainerID)
    {

        $request->validate(
            [
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',

            ],
            [
                'endDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء تاريخًا بعد تاريخ البدء أو مساويًا له'
            ]
        );
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        if ($startDate and $endDate) {
            $trainer = Trainer::find(auth()->user()->id);

            $trainerAttendances = TrainerAttendance::where('trainer_id', $trainerID)
                ->whereBetween('date', [$startDate, $endDate])->get();

            // $ = '00:00:00';
            $interval = CarbonInterval::seconds(0);
            foreach ($trainerAttendances as $attendance) {
                $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
            }
            $totalWorkingTime = $interval->format('%h:%I:%S');

            return view('trainers.attendance-report')->with(
                [
                    'trainerAttendances' => $trainerAttendances,
                    'trainer' => $trainer,
                    'totalWorkingTime' => $totalWorkingTime
                ]
            );

        } else {
            $currentDate = Carbon::now();
            $firstDateOfMonth = $currentDate->startOfMonth()->format('Y-m-d'); // Get the first date of the current month
            $lastDateOfMonth = $currentDate->endOfMonth()->format('Y-m-d'); // Get the last date of the current month
            $trainer = Trainer::find(auth()->user()->id);
            $trainerAttendances = TrainerAttendance::where('trainer_id', $trainerID)
                ->whereBetween('date', [$firstDateOfMonth, $lastDateOfMonth])->get();

            $totalTime = '00:00:00';
            $interval = CarbonInterval::seconds(0);
            foreach ($trainerAttendances as $attendance) {
                $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
            }
            $totalWorkingTime = $interval->format('%h:%I:%S');

            return view('trainers.attendance-report')->with(
                [
                    'trainerAttendances' => $trainerAttendances,
                    'trainer' => $trainer,
                    'totalWorkingTime' => $totalWorkingTime
                ]
            );
        }



    }


    // public function attendanceReport($trainerID)
    // {



    //     $currentDate = Carbon::now();
    //     $firstDateOfMonth = $currentDate->startOfMonth()->format('Y-m-d'); // Get the first date of the current month
    //     $lastDateOfMonth = $currentDate->endOfMonth()->format('Y-m-d'); // Get the last date of the current month
    //     $trainer = Trainer::find(auth()->user()->id);
    //     $trainerAttendances = TrainerAttendance::where('trainer_id', $trainerID)
    //         ->whereBetween('date', [$firstDateOfMonth, $lastDateOfMonth])->get();

    //     $totalTime = '00:00:00';
    //     $interval = CarbonInterval::seconds(0);
    //     foreach ($trainerAttendances as $attendance) {
    //         $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
    //     }
    //     $totalWorkingTime = $interval->format('%h:%I:%S');

    //     return view('trainers.attendance-report')->with(
    //         [
    //             'trainerAttendances' => $trainerAttendances,
    //             'trainer' => $trainer,
    //             'totalWorkingTime' => $totalWorkingTime
    //         ]
    //     );
    // }

    public function financialreport(Request $request, $trainerID)
    {

        $trainer = Trainer::find($trainerID);
        $request->validate(
            [
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',
            ],
            [
                'endDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء تاريخًا بعد تاريخ البدء أو مساويًا له'
            ]
        );

        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        if ($startDate and $endDate) {
            $trainerAttendances = TrainerAttendance::where('trainer_id', $trainerID)
                ->whereBetween('date', [$startDate, $endDate])->get();
            $totalWorkingTime = '00:00:00';
            $interval = CarbonInterval::seconds(0);
            foreach ($trainerAttendances as $attendance) {
                $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
            }
            $totalWorkingTime = $interval->format('%h:%I:%S');

            return view('trainers.financialreport')->with(
                [
                    'trainer' => $trainer,
                    'totalWorkingTime' => $totalWorkingTime,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ]
            );
        } else {
            $currentDate = Carbon::now();
            $firstDateOfMonth = $currentDate->startOfMonth()->format('Y-m-d'); // Get the first date of the current month
            $lastDateOfMonth = $currentDate->endOfMonth()->format('Y-m-d'); // Get the last date of the current month
            $trainerAttendances = TrainerAttendance::where('trainer_id', $trainerID)
                ->whereBetween('date', [$firstDateOfMonth, $lastDateOfMonth])->get();

            $totalWorkingTime = '00:00:00';
            $interval = CarbonInterval::seconds(0);
            foreach ($trainerAttendances as $attendance) {
                $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
            }
            $totalWorkingTime = $interval->format('%h:%I:%S');

            return view('trainers.financialreport')->with(
                [
                    'trainer' => $trainer,
                    'totalWorkingTime' => $totalWorkingTime
                ]
            );
        }


    }
}