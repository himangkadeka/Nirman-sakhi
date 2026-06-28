<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginOtp extends Model
{
    protected $table = "User.user_login_otps";
    use HasFactory;

    protected $fillable =[
        'user_id',
        'otp',
        'expire_at'
    ];
}
