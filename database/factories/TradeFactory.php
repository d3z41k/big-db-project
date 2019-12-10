<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(\App\Trade::class, function (Faker $faker) {
    return [
        'ticket' => $faker->uuid,
        'uid' => $faker->numberBetween(1, 1000),
        'amount' => $faker->randomFloat(2, 1, 1000),
        'profit' => $faker->randomFloat(2, -1000, 1000),
        'percent_profit' => $faker->numberBetween(10, 99),
        'command' => $faker->randomElement([0, 1]),
        'symbol' => $faker->randomElement([
            'GBPJPY',
            'NZDJPY',
            'USDCHF',
            'USDCAD',
            'AUDUSD',
            'EURAUD',
            'EURCAD',
            'CADCHF',
            'USDRUB',
            'EURRUB',
            'EURUSD',
            'AUDCAD_otc',
            'GBPUSD_otc',
            'USDRUB_otc',
            'USDTRY_otc',
            'EURRUB_otc',
        ]),
    ];
});
