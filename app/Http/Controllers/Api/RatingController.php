<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Trainer;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //

    public function ratings(Request $request)
    {
        $user = $request->user();
        $trainer = Trainer::where('id', $user->id)->first();
        $ratings = Rating::where('trainer_id', $trainer->id)->get();
        if ($ratings) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'كل التقيمات من قبل المشتركين',
                    'ratings' => $ratings
                ]
            );

        } else {
            return response()->json(
                [
                    'sattus' => false,
                    'message' => 'لا يموجد تقيمات إلى هذه اللحظة من قبل المشتركين'
                ],
                400
            );
        }
    }
}