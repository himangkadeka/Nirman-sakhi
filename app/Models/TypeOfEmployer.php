<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfEmployer extends Model
{
    use HasFactory;

    protected $table = "Masterdata.type_of_employers";

    protected $primaryKey = "employer_code";

    protected $fillable = [
        'employer_code',
        'employer_name'
    ];
}
