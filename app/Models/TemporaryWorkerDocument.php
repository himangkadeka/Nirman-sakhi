<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryWorkerDocument extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.temporary_worker_documents';
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id', 'application_no','residential_proof', 'work_book','worker_bank_copy',
        'nominee_bank_copy', 'ration_card','payment_acknowledgement_slip','payment_acknowledgement_slip_ext','res_proof_ext','work_book_ext','worker_bank_copy_ext', 'pan_card',
        'pan_card_ext','nominee_bank_copy_ext','ration_card_ext','subscription_payment_receipt','subscription_ext',
        'old_id_card','old_id_card_ext'];
}
