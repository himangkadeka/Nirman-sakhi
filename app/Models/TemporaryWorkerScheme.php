<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryWorkerScheme extends Model
{
    protected $guarded;
    use HasFactory;
    use SoftDeletes;
    protected $table ='Worker.temporary_worker_schemes' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id', 'application_no', 'scheme_name','registration_id','date','enrolled'
    ];

    public function scheme(){
        return $this->belongsTo(Scheme::class,'scheme_name','scheme_code');
    }

}
