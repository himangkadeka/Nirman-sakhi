<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainWorkerEmployerDetail extends Model
{
    use HasFactory;
    protected $table = 'Worker.main_worker_employer_details';
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id', 'application_no', 'employer_name','board','type_of_work','workplace','mobile_no',
        'district','subdistrict','city','pin_code','doj','nature_of_work','mgnrega_no','current_employer'];


    public function typeOfWork(){
        return $this->belongsTo(TypeOfWork::class,'type_of_work','work_type_code');
    }

    public function natureOfWorks(){
        return $this->belongsTo(NatureOfWork::class,'nature_of_work','nature_of_work_code');
    }

    public function districts(){
        return $this->belongsTo(District::class,'district','district_code');
    }

    public function subDistrict(){
        return $this->belongsTo(SubDistrict::class,'subdistrict','subdistrict_code');
    }
}
