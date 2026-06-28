<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NatureOfWork extends Model
{
    use HasFactory;

    protected $table = "Masterdata.nature_of_works";
    protected $primaryKey = "nature_of_work_code";
    protected $fillable = [
        'nature_of_work_code',
        'nature_of_work'
    ];
}
