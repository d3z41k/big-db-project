<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

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
        if (!isset($request['token']) || $request['token'] !== config('app.api_token')) {
            abort(403);
        }

        if (!isset($request['uid']) || $request['uid'] == '') {
            abort(404);
        }

        $user = DB::table('users')->find((int) $request['uid']);

        if (!$user) {
            abort(404);
        }

        return $user->balance;
    }
}
