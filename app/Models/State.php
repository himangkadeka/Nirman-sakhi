<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $table = "Masterdata.states";
    protected $primaryKey = 'state_code';
    protected $fillable = [
        'state_code',
        'state_name',
    ];

    public function districts(){
        return $this->hasMany(District::class,'state_code','state_code');
    }
}
