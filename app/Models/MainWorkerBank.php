<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainWorkerBank extends Model
{
    use HasFactory;
    protected $table = 'Worker.main_worker_banks';
    protected $primaryKey = 'id';
    protected $fillable =[
        'worker_id', 'application_no', 'ifsc_pk', 'bank_name','branch_name','bank_address','account_no','ifsc_code'
    ];
}
