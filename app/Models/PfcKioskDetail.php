<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PfcKioskDetail extends Model
{
    use HasFactory;

    protected $table = "Worker.pfc_kiosk_details";

    protected $primaryKey = "id";

    protected $fillable = [
            'rtps_trans_id',
            'user_id',
            'service_id',
            'portal_no',
            'mobile',
            'process',
            'user_type',
            'response_url',
            'kiosk_email',
            'kiosk_name',
            'kiosk_registration_id',
            'office_address',
            'worker_id',
            'is_worker_registered',
            'temporary_ticket',
            'isLoginWithPfc','is_login_csc'
    ];

    public function getCount($id)
    {
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!=',null)->get();
        foreach($transaction_ids as $transaction_id){
            $count += MainWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
        }

        return $count;
    }

    public function getCountTemp($id)
    {
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!=',null)->count();
        // foreach($transaction_ids as $transaction_id){
        //     $count += TemporaryWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
        // }

        return $transaction_ids;
    }


    public function getOnboardingCount($id)
    {
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!=',null)->where('service_id',4)->get();

        foreach($transaction_ids as $transaction_id){
            $count += MainWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
        }

        return $count;
    }

    public function getOnboardingCountTemp($id)
    {
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!=',null)->where('service_id',4)->count();

//         foreach($transaction_ids as $transaction_id){
//             $count += TemporaryWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
//         }

        return $transaction_ids;
    }

    public function getNewWorkerCount($id)
    {
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!=',null)->where('service_id',1)->get();

        foreach($transaction_ids as $transaction_id){
            $count += MainWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
        }

        return $count;
    }

    public function getNewWorkerCountTemp($id)
    {
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!='," ")->where('service_id',1)->count();

        // foreach($transaction_ids as $transaction_id){
        //     $count += TemporaryWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
        // }

        return $transaction_ids;
    }

    public function getSubscriptionCount($id){
        $count = 0;
        $count= WorkerPaymentSuccess::where('STATUS', 'F')
            ->whereNotNull('csc_txn_id')
            ->where('payment_type', 2)
            ->where('csc_id', $id)
            ->count();
        return $count;
    }

    public function getRenewalCount($id){
        $count = 0;
        $transaction_ids = PfcKioskDetail::where('kiosk_registration_id',$id)->where('worker_id','!=',null)->where('service_id',1)->get();

        foreach($transaction_ids as $transaction_id){
            $count += RenewWorkerForm::where('rtps_trans_id',$transaction_id->rtps_trans_id)->count();
        }

        return $count;

    }

    public function getAckNo($id){
        $ack_no = MainWorkerForm::where('worker_id',$id)->first()->ack_no;
        return $ack_no;
    }

    public function getDistrict($id){
        $district = MainWorkerForm::where('worker_id',$id)->first()->districtName();
        return $district;
    }


    public function getOffice($id){
        $officeName = MainWorkerForm::where('worker_id',$id)->first()->officeName();
        return $officeName;
    }

}
