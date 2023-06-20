<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FeedBack
 * @package App\Models
 * @version June 2, 2023, 9:40 am UTC
 *
 */
class FeedBack extends Model
{
    use SoftDeletes;

    public $table = 'feed_back';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'status','feed_type'
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
