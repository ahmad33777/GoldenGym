<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Trainer;
use Illuminate\Support\Facades\Validator;

class SubscriptionRenewalController extends Controller
{


    public function edit($id)
    {
        $trainers = Trainer::all();
        $subscriptions = Subscription::all();
        $subscriber = Subscriber::with('subscription')->with('trainer')->where('id', $id)->first();
        // dd($subscriber->toArray());

        return view('subscribers.subscription_renewal')->with(['trainers' => $trainers, 'subscriptions' => $subscriptions, 'subscriber' => $subscriber]);
    }

     


    public function update(Request $request, $id)
    {


        $request->validate(
            [
                'name' => 'required|string|min:10|max:255',
                'subscription_start' => 'required|date',
                'subscription_end' => 'required|date',
                'subscription_id' => 'required',
                'trainer_id' => 'required',
                'financial_boost' => 'required|numeric|min:0',


            ],
            [
                'name.required' => 'أسم المشترك مطلوب',
                'name.string' => 'يجب أن يكون حروف',
                'name.min' => 'اسم المشترك قصير جدأ',
                'name.max' => 'الأسم طويل جدأ',



                'subscription_start.required' => 'حقل بدء الاشتراك مطلوب',
                'subscription_start.date' => 'يجب أن يكون تاريخ',

                'subscription_end.required' => 'حقل نهاية الاشتراك مطلوب',
                'subscription_end.date' => 'خطأ في التنسيق يجب أن يكون تاريخ !!',
                'subscription_id.required' => 'مطلوب حقل  نوع الاشتراك',

                'trainer_id.required' => 'مطلوب حقل معرف المدرب',

                'financial_boost.required' => 'حقل التعزيز المالي مطلوب',
                'financial_boost.numeric' => 'يجب أن يكون رقم !!',
                'financial_boost.min' => 'لا ييمكن  أن تكون الدفعة الأولى أقل من صفر    '


            ]
        );

        //         "id" => 14
//   "subscription_type" => "سنوي"
//   "number_exercises" => 180
//   "subscription_price" => 400.0
//   "created_at" => "2023-05-10T16:08:07.000000Z"
//   "updated_at" => "2023-05-10T16:08:07.000000Z"
//   "deleted_at" => null

        $subscriber = Subscriber::find($id); // المشترك
        $subscription = Subscription::find($request['subscription_id']); //    معلومات الإشتراك الجديد

        $subscriber->trainer_id = $request['trainer_id'];
        $subscriber->subscription_start = $request['subscription_start'];
        $subscriber->subscription_end = $request['subscription_end'];
        $subscriber->subscription_id = $request['subscription_id'];
        $subscriber->save();

        $subscriptionPrice = $subscription->subscription_price; // سعر الإشتراك
        $subscriber->indebtedness = $subscriber->indebtedness + $subscriptionPrice;
        $subscriber->save();

        $subscriber->indebtedness = $subscriber->indebtedness - $request['financial_boost'];
        $subscriber->save();




        $incoming = new Incoming();
        $incoming->incoming_type = 'تجديد إشتراك';
        $incoming->incoming_date = date('Y-m-d');
        $incoming->incoming_value = $request['financial_boost'];
        $incoming->user_id = Auth()->user()->id;
        $incoming->subscriber_id = $subscriber->id;
        $status = $incoming->save();
        session()->flash('subscription_renewal', $status);
        return redirect()->route('subscribers.index');




    }
}