<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TemporaryWorkerCertificate extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.temporary_worker_certificates';
    protected $primaryKey = "id";

    protected $fillable =[
        'worker_id', 'application_no', 'type_of_issuer','issuing_org','issue_no','issue_date','issuing_person',
        'contact_issuing_person','is_same','employer_name','employer_contact_number',
        'from_date','to_date','date_count', 'type_of_employer','type_of_work', 'type_of_work_others', 'certificate_proof', 'profession', 'profession_others'
    ];

    public function typeOfIssuer(){
        return $this->belongsTo(TypeOfIssuer::class,'type_of_issuer','issuer_code');
    }
    public function typeOfEmployer(){
        return $this->belongsTo(TypeOfEmployer::class,'type_of_employer','employer_code');
    }
    public function professions(){
        return $this->belongsTo(Profession::class,'profession','profession_code');
    }
    public function typeOfWork(){
        return $this->belongsTo(TypeOfWork::class,'type_of_work','work_type_code');
    }
}
