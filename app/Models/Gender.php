<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    protected $table = "Masterdata.genders";
    protected $primaryKey = "gender_code";
    protected $fillable =[
        'gender_code',
        'gender_name'
    ];
}
