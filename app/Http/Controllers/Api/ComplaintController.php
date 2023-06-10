<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'complaint' => 'required|string',
                // رسالة
                // تاريخ
                'complaint_type' => 'required|string',
                // نوع الشكوى
                'subscriber_id' => 'required|exists:subscribers,id'
            ],

        );


        if (!$validator->fails()) {

            $complaint = new Complaint();
            $complaint->subscriber_id = $request->subscriber_id;
            $complaint->complaint = $request->complaint;
            $complaint->complaint_type = $request->complaint_type;
            $now = Carbon::now();
            $currentDate = $now->toDateString();
            $complaint->complaint_Date = $currentDate;
            $status = $complaint->save();

            if ($status) {
                  return response()->json(
                    [
                        'status' => true,
                        'message' => 'تمت إضافة الشكوى بنجاح . المسؤال المختص ',
                    ],
                    400
                );

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'حدث خطأ يرجى المحاولة في وقت أخر',
                    ],
                    400
                );
            }

        } else {
            $errors = $validator->errors();
            return response()->json(
                [
                    'error' => 'Validation failed',
                    'errors' => $validator->getMessageBag()->first(),
                ],
                422
            );
        }

    }
}