<?php

namespace App\Http\Controllers\Api;

use App\Trade;
use DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
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
     * @param int $tgUid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bindTG(int $tgUid)
    {
        $user = Auth::user();

        $user->tg_uid = $tgUid;
        $user->save();

        return redirect()->route('home');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getBalance(Request $request)
    {
        if (!isset($request['uid']) || $request['uid'] == '') {
            abort(404);
        }

        $user = DB::table('users')->find((int) $request['uid']);

        if (!$user) {
            abort(404);
        }

        return json_encode(['err' => '', 'message' => '', 'balance' => (string) $user->balance]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function openTrade(Request $request)
    {
        if (!isset($request['uid']) || $request['uid'] == '') {
            abort(404);
        }

        $user = DB::table('users')->find((int) $request['uid']);

        if (!$user) {
            abort(404);
        }

        try {
            Trade::insert([
                'ticket' => (string) Str::uuid(),
                'uid' => (int) $request['uid'],
                'amount' => (float) $request['amount'],
                'percent_profit' => (int) $request['payout'],
                'command' => (int) $request['command'],
                'symbol' => $request['symbol'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return  json_encode(['err' => 'true', 'message' => $e->getMessage()]);
        }

        return json_encode(['err' => '', 'message' => '']);
    }
}
