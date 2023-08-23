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

    //avatar
    const AVATAR_ARR = [
        "https://cdn.yunqirenli.com/avatar/01.jpeg",
        "https://cdn.yunqirenli.com/avatar/02.jpeg",
        "https://cdn.yunqirenli.com/avatar/03.jpeg",
        "https://cdn.yunqirenli.com/avatar/04.jpeg",
        "https://cdn.yunqirenli.com/avatar/05.jpeg",
        "https://cdn.yunqirenli.com/avatar/06.jpeg",
        "https://cdn.yunqirenli.com/avatar/07.jpeg",
        "https://cdn.yunqirenli.com/avatar/08.jpeg",
        "https://cdn.yunqirenli.com/avatar/09.jpeg",
        "https://cdn.yunqirenli.com/avatar/10.jpeg",
    ];

    public static function randomAvatar()
    {
        try {
            return self::AVATAR_ARR[random_int(0, 10)];
        } catch (\Exception $e) {
            return self::AVATAR_ARR[1];
        }
    }
}
