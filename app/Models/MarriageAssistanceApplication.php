<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarriageAssistanceApplication extends Model
{
    use HasFactory;

    protected $table = 'Benefit.marriage_assistance_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 1. Applicant Basic Details
        'worker_id',
        'family_member_id',
        'application_number',
        'application_date',
        'district_id',
        'applicant_name',
        'registration_id',
        'applicant_address',
        'applicant_dob',
        'applicant_age',
        'social_category',
        'last_contribution_date',
        'membership_duration',

        // Core Conditional Toggle
        'is_for_son_daughter',

        // 2. Marriage of Son / Daughter Details
        'spouse_is_beneficiary',
        'spouse_reg_details',
        'spouse_applied_assistance',
        'child_dob',
        'child_spouse_name',
        'child_spouse_address',
        'child_marriage_date',
        'child_marriage_number',
        'child_marriage_cert_date',
        'child_marriage_cert_no',
        'child_marriage_cert_authority',
        'child_marriage_cert_auth_address',
        'other_child_assistance_details',

        // 3. Marriage of Self (Female Worker Only) Details
        'self_bridegroom_name',
        'self_marriage_date',
        'self_marriage_place',
        'self_bridegroom_address',
        'self_marriage_cert_date',
        'self_marriage_cert_no',
        'self_marriage_cert_authority',
        'self_marriage_cert_auth_address',

        // 4. Other Details
        'received_other_assistance',

        // 5. Attachments
        'doc_bank_passbook',
        'doc_invitation_card',
        'doc_age_proof',
        'doc_marriage_certificate',
        'doc_photographs',
        'doc_signatures',

        // Application Status & Tracking
        'status',
        'remarks',
    ];

    public function worker()
    {
        return $this->belongsTo(MainWorkerForm::class,'worker_id', 'worker_id');
    }

    public function familyMember()
    {
        return $this->belongsTo(MainWorkerFamily::class, 'family_member_id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_id','district_code');
    }

     public function socialCategory(){
        return $this->belongsTo(Category::class,'social_category','category_code');
    }
}
