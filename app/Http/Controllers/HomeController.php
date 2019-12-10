<?php

namespace App\Http\Controllers;

use App\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function trades()
    {
        $trades = DB::table('trades')->limit(100000)->get();

        $totalProfit = 0;

        foreach ($trades as $trade) {
            $totalProfit += $trade->profit;
        }

        return view('trades', ['totalProfit' => $totalProfit]);
    }
}
