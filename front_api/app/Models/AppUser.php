<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AppUser
 * @package App\Models
 * @version June 2, 2023, 9:39 am UTC
 *
 */
class AppUser extends Model
{
    use SoftDeletes;

    public $table = 'app_user';


    protected $dates = ['deleted_at'];



    public $fillable = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    const USER_INVITE_CODE_START = 1000000000;


}
