<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SubscriberController extends Controller
{
    //

    public function index()
    {

        $subscribers = Subscriber::with('subscription')->with('trainer')->get();
        // dd($subscribers->toArray() );
        return view('subscribers.index')->with('subscribers', $subscribers);
    }


    public function create()
    {
        $trainers = Trainer::all();
        $subscriptions = Subscription::all();
        return view('subscribers.create')->with(['trainers' => $trainers, 'subscriptions' => $subscriptions]);
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|min:10|max:255',
                'phone' => 'required|numeric|digits:10',
                'marital_status' => 'nullable|in:أعزب,متزوج,مطلق,أرمل',
                'age' => 'nullable|integer|min:12',
                'weight' => 'nullable|numeric|min:0',
                'height' => 'nullable|numeric|min:0',
                'health_status' => 'nullable|string',
                'subscription_start' => 'required|date',
                'subscription_end' => 'required|date|after_or_equal:subscription_start',
                'subscription_id' => 'required',
                'trainer_id' => 'required',
                'first_batch' => 'nullable|numeric|min:0',


            ],
            [
                'name.required' => 'أسم المشترك مطلوب',
                'name.string' => 'يجب أن يكون حروف',
                'name.min' => 'اسم المشترك قصير جدأ',
                'name.max' => 'الأسم طويل جدأ',

                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.numeric' => 'يجب أن يكون الهاتف رقمًا',
                'phone.digits' => 'يجب أن يتكون الهاتف من 10 أرقام',

                'age.integer' => 'يجب أن يكون العمر عددًا صحيحًا',
                'age.min' => ' يجب ألا يقل عمر المشترك عن 12 عامًا',

                'weight.numeric' => 'يجب أن يكون المدخل رقم  !',
                'weight.min' => "يجب ألا يقل الوزن عن صفر .",

                "height.min" => 'لا يمكن أن يكون الطول صفر او رقم سالب',

                'health_status.string' => 'يجب أن تحتوي الحالة الصحية على أحرف فقط',

                'subscription_start.required' => 'حقل بدء الاشتراك مطلوب',
                'subscription_start.date' => 'يجب أن يكون تاريخ',

                'subscription_end.required' => 'حقل نهاية الاشتراك مطلوب',
                'subscription_end.after_or_equal' => 'يجب أن يكون تاريخ انتهاء الاشتراك بعد تاريخ بدء الاشتراك أو مساويًا له',
                'subscription_end.date' => 'خطأ في التنسيق يجب أن يكون تاريخ !!',
                'subscription_id.required' => 'مطلوب حقل  نوع الاشتراك',

                'trainer_id.required' => 'مطلوب حقل معرف المدرب',

                'first_batch.numeric' => 'يجب أن يكون رقم !!',
                'first_batch.min' => 'لا ييمكن  أن تكون الدفعة الأولى أقل من صفر    '



            ]
        ); // end Validation

        $subscriber = new Subscriber();
        $subscriber->name = $request->name;
        $subscriber->userName = $request->name; //يجب أن يعدل
        $subscriber->phone = $request->phone;
        if ($request->age) {
            $subscriber->age = $request->age;
        }
        if ($request->weight) {
            $subscriber->weight = $request->weight;
        }
        if ($request->height) {
            $subscriber->height = $request->height;
        }
        if ($request->marital_status) {
            $subscriber->marital_status = $request->marital_status;
        }
        if ($request->health_status) {
            $subscriber->health_status = $request->health_status;
        }
        $subscriber->subscription_start = $request->subscription_start;
        $subscriber->subscription_end = $request->subscription_end;
        $subscriber->subscription_id = $request->subscription_id;
        $subscriber->trainer_id = $request->trainer_id;

        if ($request->first_batch) {
            $subscriber->first_batch = $request->first_batch;
        }
        $subscriber->password = Hash::make(123456);


        $status = $subscriber->save();
        session()->flash('status', $status);


        $subscription = DB::table('subscriptions')
            ->select('subscriptions.subscription_price')
            ->where('id', $subscriber->subscription_id)
            ->first();


        $subscriber->indebtedness = $subscription->subscription_price - $subscriber->first_batch;
        $subscriber->save();

        $incoming = new Incoming();
        $incoming->incoming_type = 'إشتراك جديد';
        $incoming->incoming_date = date('Y-m-d');
        $incoming->incoming_value = $subscriber->first_batch;
        $incoming->user_id = Auth()->user()->id;
        $incoming->subscriber_id = $subscriber->id;
        $incoming->save();
        return redirect()->route('subscribers.index');


    }

    public function edit($id)
    {
        # code...
        $trainers = Trainer::all();
        $subscriptions = Subscription::all();
        $subscriber = Subscriber::find($id)->first();

        return view('subscribers.edit')->with(['trainers' => $trainers, 'subscriptions' => $subscriptions, 'subscriber' => $subscriber]);
    }

    public function update(Request $request, $id)
    {
        # code...
        $subscriber = Subscriber::find($id);
        $request->validate(
            [
                'name' => 'required|string|min:10|max:255',
                'phone' => 'required|numeric|digits:10',
                'marital_status' => 'nullable|in:أعزب,متزوج,مطلق,أرمل',
                'age' => 'nullable|integer|min:12',
                'weight' => 'nullable|numeric|min:0',
                'height' => 'nullable|numeric|min:0',
                'health_status' => 'nullable|string',
                'subscription_start' => 'required|date',
                'subscription_end' => 'required|date',
                'subscription_id' => 'required',
                'trainer_id' => 'required',
                'first_batch' => 'nullable|numeric|min:0',


            ],
            [
                'name.required' => 'أسم المشترك مطلوب',
                'name.string' => 'يجب أن يكون حروف',
                'name.min' => 'اسم المشترك قصير جدأ',
                'name.max' => 'الأسم طويل جدأ',

                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.numeric' => 'يجب أن يكون الهاتف رقمًا',
                'phone.digits' => 'يجب أن يتكون الهاتف من 10 أرقام',

                'age.integer' => 'يجب أن يكون العمر عددًا صحيحًا',
                'age.min' => ' يجب ألا يقل عمر المشترك عن 12 عامًا',

                'weight.numeric' => 'يجب أن يكون المدخل رقم  !',
                'weight.min' => "يجب ألا يقل الوزن عن صفر .",

                "height.min" => 'لا يمكن أن يكون الطول صفر او رقم سالب',

                'health_status.string' => 'يجب أن تحتوي الحالة الصحية على أحرف فقط',

                'subscription_start.required' => 'حقل بدء الاشتراك مطلوب',
                'subscription_start.date' => 'يجب أن يكون تاريخ',

                'subscription_end.required' => 'حقل نهاية الاشتراك مطلوب',
                'subscription_end.date' => 'خطأ في التنسيق يجب أن يكون تاريخ !!',
                'subscription_id.required' => 'مطلوب حقل  نوع الاشتراك',

                'trainer_id.required' => 'مطلوب حقل معرف المدرب',

                'first_batch.numeric' => 'يجب أن يكون رقم !!',
                'first_batch.min' => 'لا ييمكن  أن تكون الدفعة الأولى أقل من صفر    '



            ]
        ); // end Validation

        $subscriber->name = $request->name;
        $subscriber->userName = $request->name; //يجب أن يعدل
        $subscriber->phone = $request->phone;
        if ($request->age) {
            $subscriber->age = $request->age;
        }
        if ($request->weight) {
            $subscriber->weight = $request->weight;
        }
        if ($request->height) {
            $subscriber->height = $request->height;
        }
        if ($request->marital_status) {
            $subscriber->marital_status = $request->marital_status;
        }
        if ($request->health_status) {
            $subscriber->health_status = $request->health_status;
        }
        $subscriber->subscription_start = $request->subscription_start;
        $subscriber->subscription_end = $request->subscription_end;
        $subscriber->subscription_id = $request->subscription_id;
        $subscriber->trainer_id = $request->trainer_id;

        if ($request->first_batch) {
            $subscriber->first_batch = $request->first_batch;
        }


        $status = $subscriber->save();
        session()->flash('updateStatus', $status);

        return redirect()->route('subscribers.index');


    }


    public function destroy($id)
    {
        $subscriberDestroy = Subscriber::destroy($id);
        if ($subscriberDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        // return $search ;

        if ($search) {
            $subscribers = Subscriber::
                where(function ($query) use ($search) {
                    $query->orwhere('subscribers.name', 'LIKE', "%{$search}%");
                    $query->orWhere('subscribers.phone', 'LIKE', "%{$search}%");
                })->orderBy('id')
                ->get();

            return view('subscribers.index')->with('subscribers', $subscribers);

        } else {
            $subscribers = Subscriber::with('subscription')->with('trainer')->get();
            // dd($subscribers->toArray() );
            return view('subscribers.index')->with('subscribers', $subscribers);

        }
    }


    // ـعفعيل المشترك  
    public function changeStatusActive($id)
    {
        $subscriber = Subscriber::find($id);
        $subscriber->status = true;

        $staust = $subscriber->save();
        return redirect()->back();
    }

    // تجميد المشترك 
    public function statusChangeInactive($id)
    {
        # code...
        $subscriber = Subscriber::find($id);
        $subscriber->status = false;

        $staust = $subscriber->save();
        return redirect()->back();

    }




    public function showfinancialReport($id)
    {

        $subscriber = Subscriber::find($id)->first();
        return view('subscribers.financialReport')->with('subscriber', $subscriber);
    }

    public function financialReport($id)
    {
        $subscriber = Subscriber::find($id)->first();
        $incomings = Incoming::where('subscriber_id', $id)->get();
        $total = Incoming::where('subscriber_id', $id)->sum('incoming_value');
        return view('subscribers.financialReport')->with([
            'incomings' => $incomings,
            'total' => $total,
            'subscriber' => $subscriber
        ]);
    }

    public function searchFinancialReport(Request $request, $id)
    {

        $request->validate(
            [
                'startDate' => 'nullable|date',
                'endDate' => 'nullable|date|after_or_equal:startDate',

            ],
            [
                'endDate.date' => 'يجب أن يكون المدخل تاريخ',
                'endDate.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء تاريخًا بعد تاريخ البدء أو مساويًا له'
            ]
        );


        $subscriber = Subscriber::find($id)->first();
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        if ($startDate and $endDate) {
            $incomings = Incoming::WHERE('subscriber_id', $id)->whereBetween('incoming_date', [$startDate, $endDate])->get();
            $subscriber = Subscriber::find($id)->first();
            $total = Incoming::where('subscriber_id', $id)->whereBetween('incoming_date', [$startDate, $endDate])->sum('incoming_value');
            return view('subscribers.financialReport')->with([
                'incomings' => $incomings,
                'total' => $total,
                'subscriber' => $subscriber
            ]);
        } else {
            $incomings = Incoming::where('subscriber_id', $id)->get();
            $total = Incoming::where('subscriber_id', $id)->sum('incoming_value');

            return view('subscribers.financialReport')->with([
                'incomings' => $incomings,
                'total' => $total,
                'subscriber' => $subscriber
            ]);
        }

    }


    public function showSubscriptionReport($id)
    {
        $subscriber = Subscriber::with('subscription')->with('trainer')->find($id);
        // dd($subscriber->toArray());
        return view('subscribers.SubscriptionReport')->with('subscriber', $subscriber);
    }
 

}