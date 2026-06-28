<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainWorkerFamily extends Model
{
    protected $guarded = [];
    protected $table = 'Worker.main_worker_families';
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'application_no', 'first_name', 'last_name', 'guardain_name', 'dob', 'relation', 'nominee_percentage', 'profession', 'education', 'nominee', 'already_registered', 'already_registered_state', 'bocwwb_id', 'relation_others','is_nominee_registered','is_aadhar_verified',
        'vault_data',
        'vault_pass_key',
        'aadhar_verified_at'
    ];

    public function relationDetails()
    {
        return $this->belongsTo(Relation::class,'relation','relation_code');
    }
    public function stateDetails(){
        return $this->belongsTo(State::class,'already_registered_state','state_code');
    }

    public function professionDetails(){
        return $this->belongsTo(Profession::class,'profession','profession_code');
    }

    public function educationDetails(){
        return $this->belongsTo(Education::class,'education','education_code');
    }
}
