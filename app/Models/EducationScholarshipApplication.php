<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationScholarshipApplication extends Model
{
    use HasFactory;

    protected $table = 'Benefit.education_scholarship_applications';

    protected $fillable = [
        'worker_id',
        'family_member_id',
        'application_number',
        'application_date',
        'district_id',
        'student_name',
        'student_age',
        'student_dob',
        'social_category',
        'parent_address',
        'college_name',
        'university_board',
        'course_name',
        'course_duration_years',
        'admission_date',
        'qualifying_exam_name',
        'qualifying_exam_board',
        'qualifying_exam_year',
        'exam_marks', // JSON Field
        'parents_are_beneficiaries',
        'last_contribution_date',
        'bank_name',
        'branch_name',
        'branch_address',
        'ifsc_code',
        'account_number',
        // Documents
        'doc_bank_passbook',
        'doc_caste_certificate',
        'doc_pass_certificate',
        'doc_study_certificate',
        'doc_admission_slip',
        'doc_marksheet',
        'doc_student_photo',
        'doc_student_signature',
        'doc_affidavit',
        'status'
    ];

    // Cast JSON fields to array automatically
    protected $casts = [
        'exam_marks' => 'array',
        'application_date' => 'date',
        'student_dob' => 'date',
        'admission_date' => 'date',
        'last_contribution_date' => 'date',
    ];

    public function worker()
    {
        return $this->belongsTo(MainWorkerForm::class, 'worker_id');
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
