<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class WorkerPaymentSuccess extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "Worker.worker_payment_success";
    protected $fillable = [
        'worker_id','payment_type','DEPARTMENT_ID',"GRN","AMOUNT","BANKCODE","BANKCIN","PRN","TRANSCOMPLETIONDATETIME","STATUS","PARTYNAME","TAXID","BANKNAME","ENTRY_DATE",
        'csc_id','csc_txn_id','merchant_id','merchant_txn','merchant_receipt_no','merchant_txn_date time','product_id','product_name',
        'txn_mode','discount','error_code','error_message','bridge_response_message','enc_data'
    ];
}
