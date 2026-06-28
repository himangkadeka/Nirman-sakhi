<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomineeRegistration extends Model
{
    use HasFactory;

    protected $table = "Benefit.nominee_registrations";

    protected $fillable = [
        'worker_id',
        'name',
        'phone',
        'vault_token',
        'valut_passkey',
        'nominee_or_legal',
        'family_id',
        'nominee_percentage',
        'status',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
        'uploaded_file_path',
        'nomine_id'
    ];
}
