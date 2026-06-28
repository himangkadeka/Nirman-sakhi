<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewWorkerFormHistory extends Model
{
    use HasFactory;
    protected $table = 'Worker.renew_worker_forms_history';

    protected $guarded = []; // allow mass assignment
}
