<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RationType extends Model
{
    use HasFactory;

    protected $table = "Masterdata.ration_types";

    protected $primaryKey = "ration_code";

    protected $fillable =[
        "ration_code",
        "name"
    ];
}
