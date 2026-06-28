<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalAssistanceApplication extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Worker.medical_assistance_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'worker_id',
        'family_member_id',
        'application_number',
        'application_date',
        'district_id',
        'applicant_name',
        'applicant_address',
        'applicant_age',
        'applicant_dob',
        'registration_number',
        'social_category',
        'last_contribution_date',

        // Medical / Hospital Details
        'medical_condition_details',
        'disability_details',
        'hospital_name',
        'hospital_address',
        'treatment_period_days',
        'admission_date',
        'discharge_date',
        'previous_benefits_details',

        // Bank Details
        'bank_name',
        'ifsc_code',
        'branch_address',
        'account_number',

        // Documents
        'doc_account_paybook',
        'doc_accident_report',
        'doc_treatment_documents',
        'doc_affected_person_photograph',
        'doc_disability_certificate',

        // Tracking
        'status',
        'remarks',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'application_date'       => 'date',
        'applicant_dob'          => 'date',
        'last_contribution_date' => 'date',
        'admission_date'         => 'date',
        'discharge_date'         => 'date',
        'applicant_age'          => 'integer',
        'treatment_period_days'  => 'integer',
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
}
