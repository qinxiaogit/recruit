<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Jobs
 * @package App\Models
 * @version June 2, 2023, 8:53 am UTC
 *
 */
class Jobs extends Model
{
    use SoftDeletes;

    public $table = 'jobs';


    protected $dates = ['deleted_at'];



    public $fillable = [
        "is_top",
        "sort",
        "status"
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


}
