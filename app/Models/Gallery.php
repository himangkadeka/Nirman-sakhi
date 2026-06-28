<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'Content.galleries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'image_path', 'caption', 'category_id'
    ];


    public function getCategoryIdsAttribute()
    {
        return explode(',', $this->category_id);
    }
}
