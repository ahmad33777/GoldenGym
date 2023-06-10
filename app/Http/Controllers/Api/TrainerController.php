<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;

class TrainerController extends Controller
{
    //



    public function changePassword(Request $request)
    {
        // $trainer = Trainer::find($id);


        $validator = Validator(
            $request->all(),
            [
                'old_password' => 'required',
                'password' => 'required|min:6|max:100',
                'confirm_password' => 'required|same:password'
            ],
        );
        if (!$validator->fails()) {
            $trainer = $request->user(); // المستخد الحالي
            if (Hash::check($request->old_password, $trainer->password)) {
                $trainer = Trainer::find($trainer->id);
                $trainer->password = Hash::make($request->password);
                $result = $trainer->save();
                if ($result) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'تم تحديث كلمة المرورو بنجاح'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'فشلت عملة تغير كلمة المرور'
                        ],
                        400
                    );
                }

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'كلمة السر القديمة غير متطابقة !!'
                    ],
                    400
                );
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], 400);
        }

    }
}