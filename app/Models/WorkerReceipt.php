<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerReceipt extends Model
{
    use HasFactory;

    protected $table = "Worker.worker_receipts";

    protected $primaryKey = "id";

    protected $fillable = [
        'worker_id',
        'application_no',
        'receipt_name',
        'status'
    ];
}
