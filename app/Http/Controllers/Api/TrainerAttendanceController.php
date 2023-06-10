<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\TrainerAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrainerAttendanceController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = $request->user();
        $attendances = TrainerAttendance::where('trainer_id', $user->id)->get();
        if ($attendances) {
            return response()->json(
                [
                    'status' => true,
                    'message'=>'حضور وإنصراف الأيام التي عملت فيها',
                    'attendances' => $attendances
                ]
            );
        } else {
            return response()->json(['status' => false, 'message' => 'لايوجد حضور وإنصؤاف لهذاذ الشهر '], 400);
        }

    }


    public function attendances_store(Request $request)
    {
        $user = $request->user();
        $trainer = Trainer::where('id', $user->id)->first();


        if ($trainer) {
            if (
                !TrainerAttendance::where('trainer_id', $trainer->id)
                    ->where('date', $request->date)->first()
            ) {
                $attendance = new TrainerAttendance();
                $attendance->trainer_id = $trainer->id;
                // $currentDate = Carbon::now()->format('Y/m/d');
                $attendance->date = $request->date;
                $now = Carbon::now();
                $attendance->attendance_time = $now->format('H:i:s');
                $timeStartWork = $trainer->schedules->first()->time_in;
                $attendance->save();

                if ($attendance->attendance_time > $trainer->schedules->first()->time_in) {
                    $attendance->status_late = 1; //متاخر
                }
                $status = $attendance->save();
                if ($status) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'نجحت عملة تسجيل الحضور بإنتظار التاكيد من قبل admin',
                        ],
                        201
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'لم يتمت تسجيل الحضور حاول مرة أخري',
                        ],
                        400
                    );
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'أنتا بالفعل قمت بتسجيل حضور لهاذا اليوم'
                ], 400);
            }


        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'حدث خطأ حاول مرة أخرى'
                ],
                400
            );
        }

    }


    public function departure(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'date' => 'required|date',
            ],

        );
        if (!$validator->fails()) {
            $user = $request->user();
            $date = $request->date;
            $trainer = Trainer::where('id', $user->id)->first();
            if ($trainer) {
                if (
                    TrainerAttendance::where('trainer_id', $trainer->id)
                        ->where('date', $request->date)
                        ->where('leave_time','===',null)->first()
                ) {
                    $attendance = TrainerAttendance::
                        where('trainer_id', $trainer->id)
                        ->where('date', $date)->first();
                    $now = Carbon::now();
                    $present_time = $now->format('H:i:s');
                    $attendance->leave_time = $present_time; // وقت المغادرة
                    $status = -$attendance->save();

                    $startTime = new \DateTime($attendance->attendance_time);
                    $endTime = new \DateTime($attendance->leave_time);

                    $diff = $endTime->diff($startTime); // "startDate" => null
                    $attendance->duration_time = $diff->format('%h:%I:%S');
                    $result = $attendance->save();
                    if ($result) {
                        return response()->json(
                            [
                                'status' => true,
                                'message' => 'تمت عملية الإنصراف بنجاح لهذا اليوم'
                            ]
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => false,
                                'message' => 'لم تتم عملية الإنصراف حاول مرةأخري من فضلك ',
                            ]
                        );
                    }
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'أنت بالفعل قمت بتسجيل إنصراف'
                        ],
                        400
                    );
                }



            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'حاول مرة أخري '
                    ],
                    400
                );
            }

        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first(),
                ],
                400
            );
        }



    }
}