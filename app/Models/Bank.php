<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = "Masterdata.banks";
    protected $primaryKey = "id";
    protected $fillable =[
        'id',
        'state',
        'ifsc',
        'branch_name',
        'bank_name'
    ];
}
