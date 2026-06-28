<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostOffice extends Model
{
    use HasFactory;

    protected $table = "Masterdata.post_offices";

    protected $primaryKey = "post_office_id";

    protected $fillable =[
        'post_office_name',
        'pin_code',
        'district_code',
        'state_code'
    ];


    public function states(){
        return $this->belongsTo(State::class,'state_code','state_code');
    }

    public function districts(){
        return $this->belongsTo(District::class,'district_code','district_code');
    } 
}
