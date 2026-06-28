<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerTransaction extends Model
{
    use HasFactory;

    protected $table = 'Worker.worker_transactions';
}
