<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory;
    protected $table = 'Content.gallery_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name'
    ];
}
