<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenaralPensionApplication extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "Benefit.genaral_pension_applications";

    protected $fillable = [
        'worker_id',
        'family_member_id',
        'application_number',
        'application_date',
        'district_id',
        'first_name',
        'last_name',
        'applicant_address',
        'registration_number',
        'last_contribution_date',
        'applicant_dob',
        'applicant_age',
        'date_of_60_years',
        'recovered_loan_amount',
        'family_members_details',
        'pension_address',
        'bank_name',
        'bank_branch_name',
        'account_number',
        'mobile_number',

        // Documents
        'doc_account_paybook',

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
        'last_contribution_date' => 'date',
        'applicant_dob'          => 'date',
        'date_of_60_years'       => 'date',
        'applicant_age'          => 'integer',
        'family_members_details' => 'array', // Automatically casts JSON column to PHP array
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
