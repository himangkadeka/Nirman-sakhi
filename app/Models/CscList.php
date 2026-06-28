<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CscList extends Model
{
    use HasFactory;

    protected $table = "User.csc_lists";

    protected $fillable = [
        'cscid',
        'vlename',
        'district',
        'subdistrict',
        'gp',
        'village',
        'locality',
    ];

    // Relationship with District model
    public function districts()
    {
        return $this->belongsTo(\App\Models\District::class, 'district', 'district_name');
    }
}
