<?php

namespace App\Http\Controllers;

use Auth;
use Graze\GuzzleHttp\JsonRpc\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
//        $trades = DB::table('trades')->limit(100000)->get();
//
//        $totalProfit = 0;
//
//        foreach ($trades as $trade) {
//            $totalProfit += $trade->profit;
//        }

        $client = Client::factory('http://localhost:8081/rpc', ['headers' => ['X-Auth' => '1234567890qwertyuiop']]);

//        $body = $client->send($client->request(123, 'HelloService.SayHello', [['name' => 'Tom', 'age' => 27]]))->getBody();

        $body = $client->send($client->request(123, 'TradesService.GetCountTrades', [[
            'uids' => [42, 13, 20, 11, 21, 30],
            'symbol' => 'GBPJPY',
            'dateFrom' => '2019-05-22 00:07:27',
        ]]))->getBody();

        while (!$body->eof()) {
            $response = $body->read(1024);
        }

        $data = json_decode($response);

        return view('trades', ['totalProfit' => $data->result]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bindView(Request $request)
    {
        $user = Auth::user();

        return view('bind', ['params' => $request->all()]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function bind(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(404);
        }

        if ($user->tid == $request['tid']) {
            return 'This ID already binding';
        }

        $client = new GuzzleClient();

        try {
            $response = $client->request('POST', 'http://localhost:8000/bind', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('app.api_token'),
                ],
                'json' => [
                    'token' => config('app.api_token'),
                    'tid' => (string) $request['tid'],
                    'pocket_uid' => (string) $user->id
                ]
            ]);
        } catch(\Exception $e) {
            switch ($e->getCode()) {
                case Response::HTTP_FORBIDDEN:
                    return 'Access denied';
                    break;
                default:
                    return 'Something went wrong';
                    break;
            }
        }

        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $body = $response->getBody();

                while (!$body->eof()) {
                    $data = $body->read(1024);
                }

                $jsonResponse = json_decode($data, true);

                if ($jsonResponse['status'] == true) {
                    $user->tid = (int) $request['tid'];
                    $user->save();

                    return 'Success!';
                }
                return $jsonResponse['message'];
                break;
            case Response::HTTP_FORBIDDEN:
                return 'Access denied';
                break;
            default:
                return 'Something went wrong';
                break;
        }
    }

    /**
     * @param int $tgUid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBalance()
    {
        $user = Auth::user();

        return $user->balance;
    }

}
