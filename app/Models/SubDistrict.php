<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    use HasFactory;

    protected $table = "Masterdata.sub_districts";

    protected $primaryKey = "subdistrict_code";

    protected $fillable =[
        'subdistrict_code',
        'district_code',
        'state_code',
        'subdistrict_name'
    ];

    public function state(){
        return $this->belongsTo(State::class,'state_code','state_code');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_code','district_code');
    }
}
