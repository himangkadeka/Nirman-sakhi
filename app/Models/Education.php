<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $table = "Masterdata.educations";
    protected $primaryKey = "education_code";
    protected $fillable = [
        'education_code',
        'education_name'
    ];
}
