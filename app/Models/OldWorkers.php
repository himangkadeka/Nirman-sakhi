<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldWorkers extends Model
{
    use HasFactory;
    protected $table = "Worker.old_workers";
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id','Name', 'father_husband', 'dob' , 'district','pin','account_no','gender' ];


    public function districts(){
        return $this->belongsTo(District::class,'district_code','district_code');
    }

    public function gender(){
        return $this->belongsTo(Gender::class,'gender_id','gender_code');
    }
}
