<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TemporaryWorkerFamily extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'Worker.temporary_worker_families';
    protected $primaryKey = 'id';
    protected $fillable = [
            'worker_id', 'application_no', 'first_name', 'last_name','guardain_name', 'dob','relation','profession','education','nominee','nominee_percentage','already_registered','already_registered_state','bocwwb_id', 'relation_others'];

            public function relationDetails()
            {
                return $this->belongsTo(Relation::class,'relation','relation_code');
            }

            public function stateDetails()
            {
                return $this->belongsTo(State::class,'already_registered_state','state_code');
            }

            public function professionDetails(){
                return $this->belongsTo(Profession::class,'profession','profession_code');
            }

            public function states(){
                return $this->belongsTo(State::class,'already_registered_state','state_code');
            }

            public function educationDetails(){
                return $this->belongsTo(Education::class,'education','education_code');
            }
}
