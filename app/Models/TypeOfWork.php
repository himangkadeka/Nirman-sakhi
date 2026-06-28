<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfWork extends Model
{
    use HasFactory;

    protected $table = "Masterdata.type_of_works";

    protected $primaryKey = "work_type_code";

    protected $fillable =[
        'work_type_code',
        'work_type_name'
    ];
}
