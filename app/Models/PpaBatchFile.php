<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpaBatchFile extends Model
{
    use HasFactory;

    protected $table = "Benefit.ppa_batch_files";

    protected $fillable = [
        'batch_id',
        'ppa_signed_by_accounts',
        'accounts_signed_at',
        'ppa_signed_by_lc',
        'lc_signed_at',
        'ppa_signed_by_lm',
        'lm_signed_at',
        'transaction_id',
        'disbursed_at',
    ];
}
