<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitSubmissionLog extends Model
{
    use HasFactory;

    protected $table = "Benefit.benefit_submission_logs";

    protected $fillable = [
        'form_submission_id',
        'user_id',
        'action',
        'comment',
        'from_status',
        'file_path',
        'to_status',
    ];


    public function formSubmission()
    {
        return $this->belongsTo(FormSubmission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
