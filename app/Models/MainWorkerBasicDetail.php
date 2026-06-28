<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainWorkerBasicDetail extends Model
{
    use HasFactory;
    protected $table = 'Worker.main_worker_basic_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id',
        'application_no',
        'maritial_status_id',
        'category',
        'eshram_no',
        'education_id',
        'skill_id',
        'pf_no',
        'esic_no',
        'email',
        'pan_no',
        'resident_type',
        'state_id',
        'pan',
        'boc',
        'boc_no',
        'has_ration_card',
        'ration_no',
        'ration_type',
        'blood_group',
        'old_name',
        'old_care_of',
        'gender_id',
        'date_of_retirement',
        'old_dob',
        'subscription_validity_date',
        'subscription_receipt',
        'card_validity_date',
        'last_registration_date',
        'other_state',
        'last_renewal_date',
        'profession',
        'profession_others',
        'payment_acknowledgement_slip',
        'payment_acknowledgement_slip_ext',
        'subscription_payment_date',
        'subscription_amount_paid'

    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_code');
    }

    public function otherState()
    {
        return $this->belongsTo(State::class, 'other_state', 'state_code');
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'gender_code');
    }

    public function maritalStatus()
    {
        return $this->belongsTo(MaritalStatus::class, 'maritial_status_id', 'marital_code');
    }

    public function cateGory()
    {
        return $this->belongsTo(Category::class, 'category', 'category_code');
    }

    public function eduCation()
    {
        return $this->belongsTo(Education::class, 'education_id', 'education_code');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_code');
    }
    public function rationType()
    {
        return $this->belongsTo(RationType::class, 'ration_type', 'ration_code');
    }
    public function bloodGroup()
    {
        return $this->belongsTo(BloodGroup::class, 'blood_group', 'id');
    }

    public function Profession()
    {
        return $this->belongsTo(Profession::class, 'profession', 'profession_code');
    }

    public function getState($state_code)
    {
        $state = State::where('state_code', $state_code)->value('state_name');
        return $state;
    }

    public function mainWorkerForm()
    {
        return $this->hasOne(MainWorkerForm::class, 'worker_id', 'worker_id');
    }

    public function professions()
    {
        return $this->belongsTo(Profession::class, 'profession', 'profession_code');
    }
}
