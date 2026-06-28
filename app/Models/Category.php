<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "Masterdata.categories";
    protected $primaryKey = "category_code";
    protected $fillable= [
        'category_code',
        'category_name'
    ];
}
