<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class FormSubmission extends Model
{
    use HasFactory;

    protected $table = 'Benefit.form_submissions';

    protected $fillable = ['benefit_id', 'application_id', 'worker_id', 'status', 'batch_id', 'sanctioned_amount', 'applicant_family_member_id', 'assigned_to_user_id', 'submitted_at','scrutiny_meeting_date'];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];
    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }

    public function formSubmissionData()
    {
        return $this->hasMany(FormSubmissionData::class);
    }

    public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function logs()
    {
        return $this->hasMany(BenefitSubmissionLog::class)->oldest();
    }

    public function worker()
    {
        return $this->belongsTo(MainWorkerForm::class, 'worker_id', 'worker_id');
    }

    // No need to pass parameters, the model already knows its own data
    public function getApplicantDetails()
    {
        // 1. Set default data to prevent crashes if a code doesn't match or data is missing
        $data = [
            'name'       => 'N/A',
            'account_no' => 'N/A',
            'bank_name'  => 'N/A',
            'ifsc'       => 'N/A'
        ];

        // 2. Use the already-loaded benefit relationship to save DB queries
        $benefitCode = $this->benefit ? $this->benefit->benefit_code : null;
        $appNumber = $this->application_id; // Using the model's own application ID

        if ($benefitCode == "EA") {
            $applicant = EducationScholarshipApplication::where('application_number', $appNumber)->first();
            if ($applicant) {
                $data['name']       = $applicant->student_name;
                $data['account_no'] = $applicant->account_number;
                $data['bank_name']  = $applicant->bank_name;
                $data['ifsc']       = $applicant->ifsc_code;
            }
        } elseif ($benefitCode == "CE") {
            $applicant = CashAwardForEducationApplication::where('application_number', $appNumber)->first();
            if ($applicant) {
                $data['name']       = $applicant->student_name;
                $data['account_no'] = $applicant->account_number;
                $data['bank_name']  = $applicant->bank_name;
                $data['ifsc']       = $applicant->ifsc_code;
            }
        } elseif ($benefitCode == "MR") {
            $applicant = MarriageAssistanceApplication::where('application_number', $appNumber)->first();
            if ($applicant) {
                $data['name']       = $applicant->applicant_name;
                $data['account_no'] = '123456789';
                $data['bank_name']  = 'State Bank Of India';
                $data['ifsc']       = 'SBIN0000083';
            }
        }

        // 3. Return as an OBJECT so you can use ->name, ->account_no, etc. in Blade
        return (object) $data;
    }



    // public function getLastLogFromLowerRoleAttribute()
    // {
    //     if (!Auth::check()) {
    //         return null;
    //     }
    //     return $this->logs()->latest('id')->first();
    //     $authRoleId = Auth::user()->role_id;
    //     return $this->logs()
    //         ->whereHas('user', function ($query) use ($authRoleId) {
    //             $query->where('role_id', '<', $authRoleId);
    //         })
    //         ->latest()
    //         ->first();
    // }

    public function getForwardedByUserLogAttribute()
    {
        if (!$this->assigned_to_user_id) {
            return null;
        }

        // This query correctly finds the last "forwarding" event that resulted in the current state.
        return $this->logs()
            ->with('user')
            ->where('to_status', $this->status)
            ->latest() // Find the most recent log matching this state
            ->first();
    }
}
