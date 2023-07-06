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
        "status",
        "name",
        "one_cate_id",
        "two_cate_id",
        "method",
        "sex",
        "settlement",
        "employ_count",
        "work_start_time",
        "work_end_time",
        "work_content",
        "work_require",
        "salary",
        "unit",
        "salary_desc",
        "store_id",
        "age_start",
        "age_end",
        "store_id",
        'contact_mobile',
        'contact_qq',
        'contact_wx',
        'contact_qrcode'
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
