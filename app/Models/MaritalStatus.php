<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaritalStatus extends Model
{
    use HasFactory;

    protected $table = "Masterdata.marital_statuses";
    protected $primaryKey = "marital_code";
    protected $fillable =[
        'marital_code',
        'marital_status'
    ];
}
