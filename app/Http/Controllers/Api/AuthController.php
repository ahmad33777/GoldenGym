<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            'phone' => 'required|min:10|numeric',
            'password' => 'required|min:5',
        ]);

        if (!$validator->fails()) {
            $subscriber = Subscriber::with('subscription')->with('trainer')->where('phone', $request->get('phone'))->first();
            if ($subscriber) {
                if (Hash::check($request->get('password'), $subscriber->password)) {
                    if ($subscriber->status == 1) {
                        $token = $subscriber->createToken('subscriber')->plainTextToken;
                        return response()->json(
                            [
                                'status' => true,
                                'token' => $token,
                                'type' => 'subscriber',
                                'subscriber' => $subscriber,

                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'status' => false,
                                'message' => 'غير مصرح لك بالدخول أنت غير مصرح بك يرجى مراجة المالية'

                            ],400
                        );
                    }

                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'خطأ في كلمة المرور أو رقم الهاتف'
                        ],
                        400
                    );
                }
            } else if (!$subscriber) {
                $trainer = Trainer::where('phone', $request->get('phone'))->first();
                if (Hash::check($request->get('password'), $trainer->password)) {
                    $token = $trainer->createToken('trainer')->plainTextToken;
                    return response()->json(
                        [
                            'status' => true,
                            'token' => $token,
                            'type' => 'trainer',
                            'trainer' => $trainer,

                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'خطأ في كلمة المرور أو رقم الهاتف'
                        ],
                        400
                    );
                }
            }

        } else {
            return response()->json(['status' => false, 'message' => 'خطأ في كلمة المرور أو رقم الهاتف'], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => true,
                'message' => 'شكراً لاستخدام التطبيق'
            ],
            200
        );


    }


}