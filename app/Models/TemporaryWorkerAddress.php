<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TemporaryWorkerAddress extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.temporary_worker_addresses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'application_no', 'c_residence','c_house_type','c_circle', 'c_house_no','c_road','c_area','c_city','c_state','c_district','c_post_office','c_pin','c_std',
        'landmark','do','building','state_in_assamese','dist_in_assamese','subdist_in_assamese','po_in_assamese',
        'vill_area_in_assamese','street_in_assamese','locality_in_assamese','landmark_in_assamese', 'type_of_document'
    ];

    public function currentResidence(){
        return $this->belongsTo(Residence::class,'c_residence','residence_code');
    }

    public function currentHouse(){
        return $this->belongsTo(House::class,'c_house_type','house_code');
    }

    public function currentState(){
        return $this->belongsTo(State::class,'c_state','state_code');
    }

    public function currentDistrict(){
        return $this->belongsTo(District::class,'c_district','district_code');
    }

    public function currentSubDistrict(){
        return $this->belongsTo(SubDistrict::class,'c_circle','subdistrict_code');
    }

    public function currentPostOffice(){
        return $this->belongsTo(PostOffice::class,'c_post_office','post_office_id');
    }

}
