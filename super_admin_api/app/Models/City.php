<?php

namespace App\Models;

use Eloquent as Model;

class City extends Model
{
    public $table = 'citys';


    public $fillable = [
        'name','index','key'
    ];



}
