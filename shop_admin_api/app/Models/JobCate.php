<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JobCate
 * @package App\Models
 * @version June 2, 2023, 9:40 am UTC
 *
 */
class JobCate extends Model
{
    use SoftDeletes;

    public $table = 'job_cate';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'sort',
        'level',
        'parent_id'
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
