<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Store
 * @package App\Models
 * @version May 31, 2023, 5:57 pm UTC
 *
 * @property string $name
 * @property string $balance
 * @property string $logo
 * @property string $uid
 * @property string $album
 * @property string $contact
 * @property string $business_license
 * @property string $created_at
 */
class Store extends Model
{
    use SoftDeletes;

    public $table = 'stores';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name','uid','album','contact','business_license','logo',
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

    const STORE_STATUS_UP = 1;


}
