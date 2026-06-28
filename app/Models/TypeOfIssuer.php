<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfIssuer extends Model
{
    use HasFactory;

    protected $table = "Masterdata.type_of_issuers";

    protected $primaryKey = "issuer_code";

    protected $fillable = [
        'issuer_code',
        'issuer_name'
    ];
}
