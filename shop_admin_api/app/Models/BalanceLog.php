<?php


namespace App\Models;


use Eloquent as Model;

class BalanceLog extends Model
{
    public $table = 'balance_log';


    public $fillable = [
        'reason','direction','uid','amount','source'
    ];

}
