<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaultVerification extends Model
{
    use HasFactory;
    protected $fillable = [
        'worker_id',
        'transaction_id',
        'enc_response_data',
        'decrypted_data',
        'status',
        'api_response_time'
    ];


    public function worker()
    {
        return $this->belongsTo(MainWorkerForm::class, 'worker_id', 'worker_id');
    }

    // Accessor to turn JSON string into an Object/Array
    public function getVaultDetailsAttribute()
    {
        return json_decode($this->decrypted_data);
    }
}
