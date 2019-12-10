<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trade extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'ticket',
        'uid',
        'amount',
        'profit',
        'percent_profit',
        'command',
        'symbol',
    ];
}
