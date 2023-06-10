<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('subscriptions.index')->with('subscriptions', $subscriptions);
    }



    public function store(Request $request)
    {
        $request->validate(
            [
                'subscription_type' => ['required', 'string', 'min:4'],
                'number_exercises' => 'required|numeric|min:1',
                'subscription_price' => 'required|numeric',
            ],
            [
                'subscription_type.required' => 'نوع الإشتراك مطلوب !!',
                'subscription_type.string' => 'نوع الإشتراك يجب أن يكون حروف',
                'subscription_type.min' => 'المدخل قصير جداً',

                'number_exercises.required' => 'عدد  التمارين التي يشملها الإشتراك مطلوبة !!',
                'number_exercises.numeric' => ' خطأ في المدخل ؟ يجب أن يكون  عدد !!',
                'number_exercises.min' => 'المدخل غير صالح',

                'subscription_price.required' => 'سعر الإشتراك  جزء من الإشتراك',
                'subscription_price.numeric' => 'سعر الإشتراك  لا يمكن أن يكون  قيمة سالبة أو صفر !!',
            ]
        ); //end validation 
        // test request
        $subscription = new Subscription();
        $subscription->subscription_type = $request['subscription_type'];
        $subscription->number_exercises = $request['number_exercises'];
        $subscription->subscription_price = $request['subscription_price'];
        $status = $subscription->save();
        session()->flash('status', $status);
        return redirect()->route('subscriptions.index');

    } //end store function 
    public function edit($id)
    {
        $subscription = Subscription::find($id)->first();
        return response()->json([
            'status' => 200,
            'subscription' => $subscription
        ]);
    }
    public function update(Request $request)
    {
        // return $request ;
        $request->validate(
            [
                'edit_subscription_type' => ['required', 'string', 'min:4'],
                'edit_number_exercises' => 'required|numeric|min:1',
                'edit_subscription_price' => 'required|numeric',
            ],
            [
                'edit_subscription_type.required' => 'نوع الإشتراك مطلوب !!',
                'edit_subscription_type.string' => 'نوع الإشتراك يجب أن يكون حروف',
                'edit_subscription_type.min' => 'المدخل قصير جداً',

                'edit_number_exercises.required' => 'عدد  التمارين التي يشملها الإشتراك مطلوبة !!',
                'edit_number_exercises.numeric' => ' خطأ في المدخل ؟ يجب أن يكون  عدد !!',
                'edit_number_exercises.min' => 'المدخل غير صالح',

                'edit_subscription_price.required' => 'سعر الإشتراك  جزء من الإشتراك',
                'edit_subscription_price.numeric' => 'سعر الإشتراك  لا يمكن أن يكون  قيمة سالبة أو صفر !!',
            ]
        ); //end validation 
        // test request
        $subscription_id = $request['subscriptionID'];
        $subscription = Subscription::find($subscription_id);
        $subscription->subscription_type = $request['edit_subscription_type'];
        $subscription->number_exercises = $request['edit_number_exercises'];
        $subscription->subscription_price = $request['edit_subscription_price'];
        $updateStatus = $subscription->save();
        session()->flash('updateStatus', $updateStatus);
        return redirect()->route('subscriptions.index');

    }
    public function destroy($id)
    {
        $subscriptionDestroy = Subscription::destroy($id);
        if ($subscriptionDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }



    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $subscriptions = Subscription::
                where(function ($query) use ($search) {
                    $query->orwhere('subscriptions.subscription_type', 'LIKE', "%{$search}%");
                    $query->orWhere('subscriptions.number_exercises', 'LIKE', "%{$search}%");
                    $query->orWhere('subscriptions.subscription_price', 'LIKE', "%{$search}%");
                })
                ->get();
            return view('subscriptions.index')->with('subscriptions', $subscriptions);

        } else {
            $subscriptions = Subscription::all();
            return view('subscriptions.index')->with('subscriptions', $subscriptions);
        }
    }
}