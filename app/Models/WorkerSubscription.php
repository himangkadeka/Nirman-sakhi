<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkerSubscription extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.worker_subscriptions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'application_no', 'ack_no', 'transaction_id','total_amount','month_paid','year','subscription_type','from_period',
        'to_period','payment_status','id_card_no','office_id','fine','last_subscription','amount_paid','penalty_months','is_defaulted','no_of_delayed_months'
    ];
    public function worker()
    {
        return $this->belongsTo(MainWorkerForm::class,'worker_id','worker_id');
    }
}
