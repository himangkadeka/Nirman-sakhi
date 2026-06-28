<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainVaultData extends Model
{
    use HasFactory;

    protected $table = 'Worker.main_vault_data';

    protected $fillable = [
        'worker_id',
        'vaultToken'
    ];

    public function workerPhone()
    {
        return $this->belongsTo(MainWorkerForm::class,'worker_id','worker_id');
    }
}
