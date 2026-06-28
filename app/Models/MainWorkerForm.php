<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class MainWorkerForm extends Model
{
    use HasFactory;
    protected $table = 'Worker.main_worker_forms';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id',
        'phone_no',
        'district',
        'status',
        'office_id',
        'pull_back',
        'revert_back',
        'registration_id',
        'already_registered',
        'active_status',
        'subscription_status',
        'expiry_date',
        'renewal_date',
        'already_payment_status',
        'previous_acknowledgement_number',
        'application_no',
        'ack_no',
        'id_card',
        'id_card_created_at',
        'da_forward',
        'vaultToken',
        'aadhaar_auth',
        'vaultPassKey',
        'application_type',
        'application_receiver_user_id',
        'application_sender_user_id',
        'rtps_trans_id',
        'date_of_retirement',
        'payment_status',
        'ro_approval_time',
        'forward_to_da',
        'forward_to_ro',
        'send_back_to_ro',
        'subscription_validity_date',
        'last_registration_date',
        'id_card_expiry_date',
        'is_beneficiary',
        'default_counter',
        'is_renewal',
        'renewal_status',
        're_route',
        're_route_time',
        'hro_approval_time',
        'send_back_to_ro',
        'reasons',
        'ack_transaction_id',
        'ack_payment_date',
        'ack_payment_amount'
    ];


    public function basicDetail()
    {
        return $this->belongsTo(MainWorkerBasicDetail::class, 'worker_id', 'worker_id');
    }

    public function address()
    {
        return $this->belongsTo(MainWorkerAddress::class, 'worker_id', 'worker_id');
    }

    public function bankDetail()
    {
        return $this->belongsTo(MainWorkerBank::class, 'worker_id', 'worker_id');
    }

    public function familyDetails()
    {
        return $this->hasMany(MainWorkerFamily::class, 'worker_id', 'worker_id');
    }

    public function employerDetails()
    {
        return $this->belongsTo(MainWorkerEmployerDetail::class, 'worker_id', 'worker_id');
    }

    public function certificates()
    {
        return $this->hasMany(MainWorkerCertificate::class, 'worker_id', 'worker_id');
    }

    public function workbooks()
    {
        return $this->hasMany(WorkbookModel::class, 'worker_id', 'worker_id');
    }

    public function schemeDetails()
    {
        return $this->hasMany(MainWorkerScheme::class, 'worker_id', 'worker_id');
    }

    public function idCard()
    {
        return $this->belongsTo(WorkerIDCard::class, 'worker_id', 'worker_id');
    }

    public function districtName()
    {
        return $this->belongsTo(District::class, 'district', 'district_code');
    }

    public function officeName()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }
    public function roles()
    {
        return $this->belongsTo(Role::class, 'id', 'application_sender_id');
    }

    public function getApplicationStatus($worker_id, $application_status)
    {

        $data = WorkerApplicationStatus::where('worker_id', $worker_id)->where('application_status', $application_status)->latest()->first();
        return $data;
    }
    public function workerApplication()
    {
        return $this->hasOne(WorkerApplicationStatus::class, 'worker_id', 'worker_id');
    }

    public function GetCategory($worker_id)
    {
        $application_category = MainWorkerForm::where('worker_id', $worker_id)->first()->already_registered;
        if ($application_category == 1) {
            return 1;
        } else {
            return 0;
        }
    }
    public function vaultDataToken()
    {
        return $this->hasOne(MainVaultData::class, 'worker_id', 'worker_id');
    }

    public function basicDetails()
    {
        return $this->hasOne(MainWorkerBasicDetail::class, 'worker_id', 'worker_id');
    }

    public function certificate()
    {
        return $this->hasOne(MainWorkerCertificate::class, 'worker_id', 'worker_id');
    }

    public function worker()
    {
        return $this->belongsTo(MainWorkerForm::class, 'worker_id', 'worker_id'); // Adjust according to your Worker model
    }

    public function officeApplicationCount()
    {
        return self::where('office_id', $this->office_id)->count();
    }

    public function getReceiver()
    {
        return $this->belongsTo(User::class, 'application_receiver_user_id', 'id');
    }
    public function renewal()
    {
        return $this->hasOne(RenewWorkerForm::class, 'worker_id', 'worker_id');
    }
    public function subscriptions()
    {
        return $this->hasMany(WorkerSubscription::class, 'worker_id', 'worker_id');
    }
    public function paymentSuccess()
    {
        return $this->hasOne(WorkerPaymentSuccess::class, 'worker_id', 'worker_id')
            ->where('STATUS', 'Y')
            ->where('payment_type', 1);
    }
    public function applicationStatuses()
    {
        return $this->hasMany(WorkerApplicationStatus::class, 'worker_id', 'worker_id');
    }
}
