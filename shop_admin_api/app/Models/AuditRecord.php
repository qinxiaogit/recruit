<?php


namespace App\Models;

use Eloquent as Model;


class AuditRecord extends Model
{
    public $table = 'audit_record';


    public $fillable = [
        'extra','origin_id','source'
    ];

}
