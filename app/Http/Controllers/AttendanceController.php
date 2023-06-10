<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonInterval;

class AttendanceController extends Controller
{
    //show attendance
    public function index()
    {
        $currentDate = Carbon::now();
        $firstDateOfMonth = $currentDate->startOfMonth()->format('Y-m-d'); // Get the first date of the current month
        $lastDateOfMonth = $currentDate->endOfMonth()->format('Y-m-d'); // Get the last date of the current month
        $user = User::find(auth()->user()->id);
        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$firstDateOfMonth, $lastDateOfMonth])->get();


        $totalTime = '00:00:00';
        $interval = CarbonInterval::seconds(0);
        foreach ($attendances as $attendance) {
            $interval->add(CarbonInterval::createFromFormat('H:i:s', $attendance->duration_time))->cascade();
        }
        $totalWorkingTime = $interval->format('%h:%I:%S');
        return view('attendances.check')->with(
            [
                'attendances' => $attendances,
                'totalWorkingTime' => $totalWorkingTime
            ]
        );

    }



    public function attendances_store(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if ($user) {
            if (
                !Attendance::where('user_id', $user->id)
                    ->where('date', Carbon::now()->format('Y-m-d'))->first()
            ) {
                $attendance = new Attendance();
                $attendance->user_id = $user->id;
                $attendance->date = Carbon::now()->format('Y-m-d');
                $now = Carbon::now();
                $attendance->attendance_time = $now->format('H:i:s');
                // $timeStartWork = $user->schedules->first()->time_in;
                $attendance->save();

                // if ($attendance->attendance_time > $user->schedules->first()->time_in) {
                //     $attendance->status_late = 1; //متاخر
                // }
                $status = $attendance->save();
                if ($status === true) {
                    session()->flash('statusS', 'نجحت عملية تسجيل الحضور في انتظار الاعتماد من قبل الموظف المختص');
                    return redirect()->back();

                } else {
                    session()->flash('statusF', 'فشلت عملية تسجيل الحضور  حاول ممرة أخري   ');
                    return redirect()->back();

                }


            } else {
                session()->flash('statusAtt', 'أنت بالفعل قمت بعملية تسجيل الحضور لهاذا اليوم');
                return redirect()->back();
            }

        }
    }


    public function departure(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if ($user) {
            $attendance = Attendance::where('user_id', $user->id)->where('date', Carbon::now()->format('Y-m-d'))->first();
            if ($attendance->leave_time == null) {
                $now = Carbon::now();
                $present_time = $now->format('H:i:s');
                $attendance->leave_time = $present_time; // وقت المغادرة
                $status = -$attendance->save();

                $startTime = new \DateTime($attendance->attendance_time);
                $endTime = new \DateTime($attendance->leave_time);

                $diff = $endTime->diff($startTime); // "startDate" => null
                $attendance->duration_time = $diff->format('%h:%I:%S');
                $result = $attendance->save();
                if ($result === true) {
                    session()->flash('statusSL', 'نجحت عملية تسجيل الإنتظار في انتظار الاعتماد من قبل الموظف المختص');
                    return redirect()->back();
                } else {
                    session()->flash('statusFL', 'فشلت عملية تسجيل الانصراف  حاول ممرة أخري   ');
                    return redirect()->back();
                }
            } else {
                session()->flash('statusleave', 'أنت بالفعل قمت بعملية تسجيل انصراف لهاذا اليوم');

                return redirect()->back();
            }
        }
    }




    public function attendanceRequests()
    {
        $attendances = Attendance::with('user')
            ->where('order_status', null)
            ->get();
        // dd($attendances->toArray());
        return view('attendances.attendance-requests')->with('attendances', $attendances);
    }



    public function acceptAttendance(Request $request)
    {
        $user_id = $request['user_id'];
        $date = $request['attendance_date'];

        $attendance = Attendance::where('user_id', $user_id)
            ->where('date', $date)
            ->where('order_status', null)
            ->first();

        $attendance->order_status = 1;
        $status = $attendance->save();

        session()->flash('status', $status);
        return redirect()->route('attendance.attendanceRequests');


    }


    public function rejectionAttendance(Request $request)
    {
        $user_id = $request['user_id'];
        $date = $request['attendance_date'];

        $attendance = Attendance::where('user_id', $user_id)
            ->where('date', $date)
            ->where('order_status', null)
            ->first();

        $attendance->order_status = 0;
        $rejectstatus = $attendance->save();

        session()->flash('rejectstatus', $rejectstatus);
        return redirect()->route('attendance.attendanceRequests');
    }



    // public function sheetReport()
    // {
    //     return view('attendances.sheet-report');
    // }


}