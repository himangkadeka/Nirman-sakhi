<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $table = 'Content.contents';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'description'
    ];

    public static function getDescriptionByTitle($title)
    {
        $content = self::where('title', $title)->first();

        if ($content) {
            return $content->description;
        }

        return null;
    }
}


