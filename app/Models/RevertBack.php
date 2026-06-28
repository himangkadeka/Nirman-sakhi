<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevertBack extends Model
{
    use HasFactory;
    protected $table ='Worker.revert_backs' ;
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id', 'phone_no','district','status','office_id','revert_back','registration_id','already_registered','active_status','subscription_status','expiry_date','renewal_date',
        'application_no','ack_no','vaultToken','aadhaar_auth',
        'vaultPassKey','application_type','reasons','revert_back_status'
    ];

    public function getApplicationStatus($worker_id, $application_status)
    {

        $data = WorkerApplicationStatus::where('worker_id', $worker_id)->where('application_status', $application_status)->latest()->first();
        return $data;
    }

    public function officeName()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }


}
