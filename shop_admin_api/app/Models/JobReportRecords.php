<?php


namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobReportRecords extends Model
{
    use SoftDeletes;

    public $table = 'job_report_records';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'job_id',
        'uid',
        'status',
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
