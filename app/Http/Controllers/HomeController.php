<?php

namespace App\Http\Controllers;

use App\Trade;
use Graze\GuzzleHttp\JsonRpc\Client;
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
}
