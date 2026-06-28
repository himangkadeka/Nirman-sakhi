<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempData extends Model
{
    use HasFactory;
    protected $table = "Worker.temp_data";

    protected $primaryKey = "id";

    protected $fillable =[
        'old_name',
        'old_fathers_name',
        'old_gender',
        'old_dob'
    ];
}
