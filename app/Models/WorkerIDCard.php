<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerIDCard extends Model
{
    use HasFactory;
    protected $table ='Worker.worker_id_cards' ;
    protected $primaryKey = 'id';
    protected $fillable = [
        'worker_id',
        'signature_status',
        'certificate',
        'certificate_upload_date',
        'is_id_card_downloadble',
        'id_card_status'
    ];

    public function getMainWorker(){
        return $this->belongsTo(MainWorkerForm::class,'worker_id','worker_id');
    }
}
