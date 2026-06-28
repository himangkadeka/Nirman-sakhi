<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeProof extends Model
{
    use HasFactory;
    protected $table = "Masterdata.age_proofs";
    protected $primaryKey = "age_proof_code";
    protected $fillable =[
        'age_proof_code',
        'age_proof_name'
    ];
}
