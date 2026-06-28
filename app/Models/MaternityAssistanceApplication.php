<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaternityAssistanceApplication extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Benefit.maternity_assistance_applications';

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
        'bocw_registration_number',
        'hospital_name',
        'hospital_address',
        'applicant_age',
        'applicant_dob',
        'husband_name',
        'date_of_confinement',
        'applied_earlier',
        'times_applied_earlier',
        'previous_application_details',
        'last_contribution_date',
        'bank_name',
        'ifsc_code',
        'branch_address',
        'bank_account_number',

        // Documents
        'doc_account_paybook',
        'doc_medical_certificate',

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
        'date_of_confinement'    => 'date',
        'last_contribution_date' => 'date',
        'applicant_age'          => 'integer',
        'times_applied_earlier'  => 'integer',
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
