<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;

    protected $table = "Masterdata.schemes";

    protected $primaryKey = "scheme_code";

    protected $fillable =[
        'scheme_code',
        'scheme_name'
    ];
}
