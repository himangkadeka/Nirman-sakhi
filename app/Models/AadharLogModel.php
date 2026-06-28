<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AadharLogModel extends Model
{
    use HasFactory;
    protected $table = "User.aadhar_log_retention";
    protected $fillable = [
        'id','ip_address','token_id','consent'
    ];
}
