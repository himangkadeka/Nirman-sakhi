<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPaymentTransaction extends Model
{
    use HasFactory;
    protected $table = 'Worker.worker_payment_transactions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id','application_no','ack_no','from_period','to_period','fine','total_amount','transaction_id','status','office_id','previous_dues'
    ];
}
