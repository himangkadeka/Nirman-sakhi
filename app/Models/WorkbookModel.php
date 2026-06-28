<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkbookModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.workers_workbook_details';

    protected $fillable = [
        'worker_id','application_no', 'type_of_work','employer_name','employer_contact_number',
        'from_date','to_date','date_count','type_of_employer','profession','profession_others','certificate_proof','row_id','group_id','sub_row'
    ];
    public function typeOfIssuer(){
        return $this->belongsTo(TypeOfIssuer::class,'type_of_issuer','issuer_code');
    }
    public function typeOfEmployer(){
        return $this->belongsTo(TypeOfEmployer::class,'type_of_employer','employer_code');
    }
    public function typeOfWork(){
        return $this->belongsTo(TypeOfWork::class,'type_of_work','work_type_code');
    }
    public function professions(){
        return $this->belongsTo(Profession::class,'profession','profession_code');
    }
    public function getIsParentAttribute(): bool
    {
        return str_ends_with((string) $this->row_id, '.0');
    }
    public function getDateRangeKeyAttribute(): int
    {
        return (int) $this->row_id;
    }
}
