<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $table = "Masterdata.houses";
    protected $primaryKey = "house_code";
    protected $fillable = [
        'house_code',
        'house_type'
    ];
}
