<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaultAccessLog extends Model
{
    use HasFactory;
    protected $table = 'User.vault_access_logs';
    protected $fillable = [
        'worker_id',
        'family_id',
        'user_id',
        'username',
        'role_id',
        'role_name',
        'office_code',
        'designation',
        'module_name',
        'action_type',
        'source',
        'transaction_id',
        'ip_address',
        'user_agent',
        'accessed_at',
        'session_id'
    ];
}
