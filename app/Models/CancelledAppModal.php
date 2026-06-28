<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelledAppModal extends Model
{
    use HasFactory;
    protected $table ='Worker.reject_applications' ;
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id', 'phone_no','district','status','office_id','already_registered','active_status',
        'application_no','ack_no','vaultToken', 'vaultPassKey','application_type','remarks'
    ];
    public function getApplicationStatus($worker_id, $application_status)
    {

        $data = WorkerApplicationStatus::where('worker_id', $worker_id)->where('application_status', $application_status)->latest()->first();
        return $data;
    }
    public function workerStatus()
    {
        return $this->hasOne(WorkerApplicationStatus::class, 'worker_id', 'worker_id')
            ->where('application_status', 'D');
    }

    public function districtName()
    {
        return $this->belongsTo(District::class, 'district', 'district_code');
    }

    public function officeName()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }


}
