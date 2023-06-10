<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FinancialController extends Controller
{

    public function edit($id)
    {

        $subscriber = Subscriber::find($id);
        return response()->json([
            'status' => 200,
            'subscriber' => $subscriber
        ]);

    }

    // دفعة مالية
    public function financial_boost(Request $request)
    {
        $request->validate(
            [
                'financial_boost' => 'required|numeric|min:0',
            ],
            [
                'financial_boost.required' => 'في حال كنت تريد اضافة دفعة مالية يجب أن تدخل الدفعة المالية',
                'financial_boost.numeric' => ' المدخل غير صحيح',
                'financial_boost.min' => 'يجب أن تكون الدفعة المالية فوق  0 على الأقل'
            ]
        );

        $subscriberID = $request['subID'];

        $subscriber = Subscriber::where('id', $subscriberID)->first();
        $indebtedness = $subscriber->indebtedness; // المديونية
        $financial_value = $request['financial_boost']; // الدفعة الملية

        $subscriber->indebtedness = $indebtedness - $financial_value;
        $subscriber->save();
        $incoming = new Incoming();
        $incoming->incoming_type = 'دفعة إشتراك';
        $incoming->incoming_date = date('Y-m-d');
        $incoming->incoming_value = $financial_value;
        $incoming->user_id = Auth()->user()->id;
        $incoming->subscriber_id = $subscriber->id;
        $status = $incoming->save();
        session()->flash('incomingstatus', $status);
        return redirect()->route('subscribers.index');

    }



    

}