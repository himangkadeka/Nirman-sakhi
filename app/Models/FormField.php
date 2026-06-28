<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $table = 'Benefit.form_fields';

    protected $fillable = [
        'benefit_id',
        'name',
        'type',
        'validation_rules',
        'error_messages',
        'order',
        'options',
        'masterdata_table',
        'use_masterdata',
        'masterdata_table_key',
        'masterdata_table_value',
        'validation_rules',
        'error_messages',
        'options',
        'order',
        'use_prefilled_data',
        'prefilled_data_type',
        'prefilled_vault_data_key',
        'prefilled_worker_data_table',
        'prefilled_worker_data_key',
        'use_masterdata_value',
        'masterdata_value_table',
        'masterdata_value_table_key',
        'masterdata_value_table_value',
        'is_required',
        'is_readonly',
        'is_hidden',
        'is_disabled',
        'is_dependent_field',
        'dependent_field_id',
        'dependent_field_value',
        'status',
        'masterdata_table_condition',
        'prefilled_table_name',
        'prefilled_table_columns',
        'prefilled_table_headers',
        'prefilled_table_condition_column'
    ];


    public function form()
    {
        return $this->belongsTo(Benefit::class);
    }

    public function submissionData()
    {
        return $this->hasMany(FormSubmissionData::class);
    }
}
