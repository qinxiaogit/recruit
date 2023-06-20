<?php


namespace App\Models;


use Eloquent as Model;

class AuditLog extends Model
{
    public $table = 'audit_log';


    public $fillable = [
        'reason','result','uid'
    ];

}
