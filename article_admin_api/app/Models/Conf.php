<?php


namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conf extends Model
{
    use SoftDeletes;

    public $table = 'conf';

    protected $dates = ['deleted_at'];
}
