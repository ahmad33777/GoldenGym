<?php

namespace App\Http\Controllers;

use App\Models\TrainerAttendance;
use Illuminate\Http\Request;

class TrainerAttendanceController extends Controller
{
    //
    public function index()
    {
        $attendances = TrainerAttendance::with('trainer')
            ->where('order_status', null)
            ->get();
         return view('attendances.attendance-requests-trainers')->with('attendances', $attendances);
    }



    public function acceptTrainerAttendance(Request $request)
    {
        $trainer_id = $request['trainer_id'];
        $date = $request['attendance_date'];

        $attendance = TrainerAttendance::where('trainer_id', $trainer_id)
            ->where('date', $date)
            ->where('order_status', null)
            ->first();

        $attendance->order_status = 1;
        $status = $attendance->save();

        session()->flash('status', $status);
        return redirect()->back();


    }


    public function rejectionTrainerAttendance(Request $request)
    {
        $trainer_id = $request['trainer_id'];
        $date = $request['attendance_date'];

        $attendance = TrainerAttendance::where('trainer_id', $trainer_id)
            ->where('date', $date)
            ->where('order_status', null)
            ->first();

        $attendance->order_status = 0;
        $rejectstatus = $attendance->save();

        session()->flash('rejectstatus', $rejectstatus);
        return redirect()->back();
    }

}