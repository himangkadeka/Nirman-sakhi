<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryWorkerForm extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.temporary_worker_forms';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id',
        'phone_no',
        'district_id',
        'office_id',
        'already_payment_status',
        'previous_acknowledgement_number',
        'ack_transaction_id',
        'ack_payment_date',
        'ack_payment_amount',
        'already_registered',
        'application_no',
        'aadhaar_auth',
        'vaultToken',
        'vaultPassKey',
        'rtps_trans_id'
    ];

    public function basicDetail()
    {
        return $this->belongsTo(TemporaryWorkerBasicDetail::class, 'worker_id', 'worker_id');
    }

    public function address()
    {
        return $this->belongsTo(TemporaryWorkerAddress::class, 'worker_id', 'worker_id');
    }

    public function bankDetail()
    {
        return $this->belongsTo(TemporaryWorkerBank::class, 'worker_id', 'worker_id');
    }

    public function familyDetails()
    {
        return $this->hasMany(TemporaryWorkerFamily::class, 'worker_id', 'worker_id');
    }

    public function employerDetails()
    {
        return $this->belongsTo(TemporaryWorkerEmployerDetail::class, 'worker_id', 'worker_id');
    }

    public function certificates()
    {
        return $this->hasMany(TemporaryWorkerCertificate::class, 'worker_id', 'worker_id');
    }

    public function schemeDetails()
    {
        return $this->hasMany(TemporaryWorkerScheme::class, 'worker_id', 'worker_id');
    }
    public function officeName()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }
    public function officeNameOthers()
    {
        return $this->belongsTo(Office::class, 'other_state', 'office_id');
    }
}
