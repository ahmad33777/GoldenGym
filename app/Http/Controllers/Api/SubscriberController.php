<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    //
    public function index()
    {
        $subscribers = Subscriber::with('subscription')->with('trainer')->get();
        return response()->json([
            'status' => true,
            'subscribers' => $subscribers
        ], 200);
    }
}