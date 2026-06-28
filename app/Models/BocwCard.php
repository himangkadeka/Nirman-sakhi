<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BocwCard extends Model
{
    use HasFactory;

    protected $table = "Worker.bocw_cards";
    protected $primaryKey = "id";
    protected $fillable =[
        'worker_id',
        'existing_card'
    ];
}
