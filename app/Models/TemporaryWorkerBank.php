<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TemporaryWorkerBank extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.temporary_worker_banks';
    protected $primaryKey = 'id';
    protected $fillable =[
       'worker_id', 'application_no', 'ifsc_pk', 'bank_name','branch_name','bank_address','account_no','cnf_account_no','ifsc_code'
    ];
}
