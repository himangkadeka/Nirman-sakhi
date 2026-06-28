<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryWorkerBasicDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.temporary_worker_basic_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'application_no','maritial_status_id','category','eshram_no','education_id',
        'skill_id','pf_no','esic_no','email','pan_no', 'resident_type','state_id','pan','boc','boc_no','has_ration_card',
        'ration_no','ration_type','blood_group','old_name','old_care_of','gender_id','date_of_retirement','old_dob',
        'subscription_validity_date','card_validity_date','last_registration_date','other_state','last_renewal_date',
        'profession', 'profession_others', 'payment_acknowledgement_slip', 'payment_acknowledgement_slip_ext', 'subscription_payment_date', 'subscription_amount_paid','subscription_receipt','transaction_id','ack_amount','ack_payment_date'
    ];
    public function form()
    {
        return $this->hasOne(TemporaryWorkerForm::class, 'worker_id', 'worker_id');
    }

    public function Profession(){
        return $this->belongsTo(Profession::class,'profession','profession_code');
    }

    public function state(){
        return $this->belongsTo(State::class,'state_id','state_code');
    }
    public function gender(){
        return $this->belongsTo(Gender::class,'gender_id','gender_code');
    }

    public function maritalStatus(){
        return $this->belongsTo(MaritalStatus::class,'maritial_status_id','marital_code');
    }

    public function cateGory(){
        return $this->belongsTo(Category::class,'category','category_code');
    }

    public function eduCation(){
        return $this->belongsTo(Education::class,'education_id','education_code');
    }

    public function skill(){
        return $this->belongsTo(Skill::class,'skill_id','skill_code');
    }
    public function rationType(){
        return $this->belongsTo(RationType::class,'ration_type','ration_code');
    }

    public function bloodGroup(){
        return $this->belongsTo(BloodGroup::class,'blood_group','id');
    }

    public function getReasons($workerId)
    {
        $worker = TemporaryWorkerBasicDetail::find($workerId);

        // Ensure the worker object is not null
        if (empty($worker)) {
            return collect(); // Return an empty collection
        }

        // Ensure the reasons field is not null or empty
        if (empty($worker->reasons)) {
            return collect(); // Return an empty collection
        }

        // Explode the comma-separated reason IDs into an array
        $reason_ids_array = array_filter(explode(',', $worker->reasons));

        // Ensure the array has valid IDs
        if (empty($reason_ids_array)) {
            return collect(); // Return an empty collection
        }

        // Fetch the corresponding reason objects from the Reason table
        $reasons = Reasons::whereIn('id', $reason_ids_array)->get();

        return $reasons;
    }


}
