<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use HasFactory;

    protected $table = "Masterdata.residences";

    protected $primaryKey = "residence_code";

    protected $fillable = [
        'residence_code',
        'residence_name'
    ];
}
