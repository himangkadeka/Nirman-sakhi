<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $table = "Masterdata.skills";

    protected $primaryKey = "skill_code";

    protected $fillable = [
        'skill_code',
        'skill_name'
    ];

   
}
