<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Incoming;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {

        $numberSubscribers = Subscriber::count();
        $employees = User::count();
        $trainers = Trainer::count();
        $incomings = Incoming::sum('incoming_value');

        $currentDate = date('Y-m-d');

        $dailyExpenses = Incoming::where('incoming_date', $currentDate)->sum('incoming_value');
         // dd( );
        return view('home')->with([
            'subscribers' => $numberSubscribers,
            'employees' => $employees,
            'trainers' => $trainers,
            'incomings' => $incomings,
            'dailyExpenses'=>$dailyExpenses
        ]);
    }
}