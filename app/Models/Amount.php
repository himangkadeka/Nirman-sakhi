<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    use HasFactory;

    protected $table = "Masterdata.amounts";

    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'amount_description', 
        'amount'
    ];
}
