<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerRenewal extends Model
{
    protected $table = 'Worker.worker_renewals';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'ack_no','id_card','office_id','fine','total_amount','renewal_fee'
    ];
}
