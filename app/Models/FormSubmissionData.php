<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmissionData extends Model
{
    use HasFactory;

    protected $table = 'Benefit.form_submission_data';

    protected $fillable = [
        'form_submission_id',
        'form_field_id',
        'value'
    ];

    public function formSubmission()
    {
        return $this->belongsTo(FormSubmission::class);
    }

    public function formField()
    {
        return $this->belongsTo(FormField::class);
    }
}
