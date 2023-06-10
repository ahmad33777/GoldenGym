<?php

namespace App\Http\Controllers;

use App\Models\schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $schedules = Schedule::all();
        // dd($schedules);
        return view('schedules.index')->with('schedules', $schedules);
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

        $request->validate(
            [
                'name' => 'required|string|min:5|nullable',
                'time_in' => "required|",
                'time_out' => 'required|',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب ',
                'name.string' => 'يجب أن يكون الأسم حروف فقط',
                'name.min' => 'لا يمكن أن يكون الأسم أقل من 5 أحرف !!!',
                'name.nullable' => 'لا يمكن أن يكون الأسم  فارغ ',
                'time_in.required' => 'هذا الحقل مطلوب ',
                'time_out.required' => 'هذا الحقل مطلوب ',


            ]
        );
        // dd($request->toArray());
        $schedule = new schedule();

        $schedule->name = $request->name;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;



        $temp = explode(':', $request->time_in);
        $hour = $temp[0]; // ساعات 
        // $minutes  = $temp[1]; // دقائق
        if ($hour > 12) {
            $schedule->type = 'PM';
        } else if ($hour < 12) {
            $schedule->type = 'AM';
        } else {
            $schedule->type = 'PM';
        }

        $status = $schedule->save();
        session()->flash('status', $status);
        // flash()->success('Success','Schedule has been created successfully !');
        return redirect()->route('schedules.index');



    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $schedule = Schedule::find($id);
        return response()->json([
            'status' => 200,
            'schedule' => $schedule
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->toArray());

        $request->validate(
            [
                'name' => 'required|string|min:5|nullable',
                'time_in' => "required|",
                'time_out' => 'required|',
            ],
            [
                'name.required' => 'هذا الحقل مطلوب ',
                'name.string' => 'يجب أن يكون الأسم حروف فقط',
                'name.min' => 'لا يمكن أن يكون الأسم أقل من 5 أحرف !!!',
                'name.nullable' => 'لا يمكن أن يكون الأسم  فارغ ',
                'time_in.required' => 'هذا الحقل مطلوب ',
                'time_out.required' => 'هذا الحقل مطلوب ',


            ]
        );
        $schedule_id = $request['scheduleID'];
        $schedule = schedule::find($schedule_id);

        $schedule->name = $request->name;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;



        $temp = explode(':', $request->time_in);
        $hour = $temp[0]; // ساعات 
        // $minutes  = $temp[1]; // دقائق
        if ($hour > 12) {
            $schedule->type = 'PM';
        } else if ($hour < 12) {
            $schedule->type = 'AM';
        } else {
            $schedule->type = 'PM';
        }

        $status = $schedule->save();
        session()->flash('statusUpdate', $status);
        //  flash()->success('Success','Schedule has been created successfully !');
        return redirect()->route('schedules.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $scheduleDestroy = Schedule::destroy($id);
        if ($scheduleDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }
}