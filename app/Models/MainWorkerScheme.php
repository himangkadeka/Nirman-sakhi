<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainWorkerScheme extends Model
{
    protected $guarded;
    use HasFactory;
    protected $table ='Worker.main_worker_schemes' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id','application_no','scheme_name','registration_id','date','enrolled'
    ];

    public function scheme(){
        return $this->belongsTo(Scheme::class,'scheme_name','scheme_code');
    }
}
