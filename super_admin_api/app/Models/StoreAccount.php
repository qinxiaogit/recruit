<?php


namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreAccount extends Model
{
    use SoftDeletes;

    public $table = 'store_account';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'username','password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}
