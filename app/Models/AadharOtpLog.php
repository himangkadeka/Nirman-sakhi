<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AadharOtpLog extends Model
{
    use HasFactory;
    protected $table = "User.aadhar_otp_logs";
    protected $fillable = [
        'id','errorCode','errorDescription','mobile','status','transaction_id','ip'
    ];
}
