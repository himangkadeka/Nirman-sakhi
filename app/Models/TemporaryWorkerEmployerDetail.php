<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryWorkerEmployerDetail extends Model
{
    use HasFactory;
    protected $table = 'Worker.temporary_worker_employer_details';
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id','application_no', 'employer_name','type_of_employer','type_of_work','workplace','mobile_no',
        'date_of_joining','nature_of_work','current_employer', 'employer_address'];

    public function typeOfWork(){
        return $this->belongsTo(TypeOfWork::class,'type_of_work','work_type_code');
    }

    public function natureOfWorks(){
        return $this->belongsTo(NatureOfWork::class,'nature_of_work','nature_of_work_code');
    }

    public function districts(){
        return $this->belongsTo(District::class,'district_id','district_code');
    }

    public function subDistrict(){
        return $this->belongsTo(SubDistrict::class,'subdistrict_id','subdistrict_code');
    }
    public function typeOfEmployer(){
        return $this->belongsTo(TypeOfEmployer::class,'type_of_employer','employer_code');
    }
}
