<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PfcList extends Model
{
    use HasFactory;

    protected $table = "User.pfc_lists";
    protected $primaryKey = "id";
    protected $fillable = [
        'name_of_pfc',
        'pfc_name',
        'postal_address',
        'pin_code',
        'nearby_landmark',
        'latitude',
        'longitude',
        'district_code',
    ];

    // Relationship with the District model (PFC belongs to a district)
    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }
}
