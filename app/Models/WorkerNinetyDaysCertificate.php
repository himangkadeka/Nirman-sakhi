<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerNinetyDaysCertificate extends Model
{
    use HasFactory;
    protected $table ='Worker.worker_ninety_days_certificates' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id',
        'ninety_days_certificate',
    ];
}
