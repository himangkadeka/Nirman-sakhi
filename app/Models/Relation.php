<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    protected $table = 'Masterdata.relations';

    protected $fillable = [
        'relation_code',
        'relation_name',
        'gender'
    ];
}
