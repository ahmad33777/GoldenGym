<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncomingController extends Controller
{
    //
    public function index(Request $request)
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
        $startDate = $request['startDate'];
        $endDate = $request['endDate'];
        // dd($incomings->toArray());
        if ($startDate and $endDate) {
            $incomings = Incoming::whereBetween('incoming_date', [$startDate, $endDate])->paginate(30);
            return view('incomings.index')->with([
                'incomins' => $incomings,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        } else {
            $incomings = Incoming::paginate(30);

            return view('incomings.index')->with([
                'incomins' => $incomings,
            ]);

        }

    }
}