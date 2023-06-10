<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Trainer;
use App\Models\Latetime;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceController;

class CheckController extends Controller
{
    //

    public function index()
    {
         $trainers =  Trainer::all();
        return view('trainers.check')->with('trainers', $trainers);

    }


    public function checkStore(Request $request){
      //  بتحسب الفرق في الساعات بين الوقت
        // $now = Carbon::now();
        // $present_time = $now->format('h:i:s');
        // $start_datetime = new DateTime($present_time);
        // $time = '01:00:00' ;
        // $diff =  $start_datetime->diff(new DateTime($time));
        // dd($diff->h);
        // dd($request->toArray());


        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($trainer = Trainer::whereId(request('trainer_id'))->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereTrainer_id($key)
                                ->first()
                        ) {
                            $data = new Attendance();

                            $data->trainer_id = $key;
                            $traner_req = Trainer::whereId($data->trainer_id)->first();
                            $now = Carbon::now();
                            $present_time = $now->format('h:i:s');
                            $data->attendance_time = $present_time;
                            $data->attendance_date = $keys;
                            $data->state = 1;

                           // وقت  بدياة الشفت يلي الموظف مسجل فيه
                            $emps = date('h:i:s', strtotime($trainer->schedules->first()->time_in));
                             if ($data->attendance_time  > $emps ) {
                                $data->status = 0;
                                AttendanceController::lateTime($trainer);
                             }
                          $status =   $data->save();
                          session()->flash('status', $status);


                        }
                    }
                }
                 return back();
            }
        }

        if (isset($request->leave)) {
            // dd($request->leave);
            foreach ($request->leave as $date => $values) {
                // dd($date);
                foreach ($values as $trainer_id => $value) {
                      $atten   = Attendance::where('trainer_id',$trainer_id)
                      ->where('attendance_date',$date)
                      ->first();
                      if($atten->leave_time == null){
                        $now = Carbon::now();
                        $present_time = $now->format('h:i:s');
                        $atten->leave_time = $present_time;
                        $atten->save();
                        $clockIn = Carbon::parse($atten->attendance_time);
                        $clockOut = Carbon::parse($atten->leave_time);
                        $workingTime = $clockOut->diff($clockIn)->format('%h:%i');
                        $atten->working_time = $workingTime ;
                        
                        $status =  $atten->save();
                        session()->flash('status', $status);
                      }
                       
            }
        }
         
        return back();
    }
}

    public function sheetReport()
    {

        
    }

}
